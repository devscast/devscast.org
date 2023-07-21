<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\Controller;

use Domain\Authentication\Entity\ResetPasswordToken;
use Domain\Authentication\Entity\User;
use Tests\FixturesTrait;
use Tests\WebTestCase;

final class ResetPasswordControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function testResetPasswordRequestPageIsAvailable(): void
    {
        $this->client->request('GET', 'password/request');
        $this->assertResponseIsSuccessful();
    }

    public function testResetPasswordBlockBadEmails(): void
    {
        $crawler = $this->client->request('GET', '/password/request');
        $this->expectFormErrors(0);
        $form = $crawler->selectButton('Suivant')->form();
        $form->setValues([
            'request_reset_password_form[email]' => 'invalid',
        ]);
        $this->client->submit($form);
        $this->expectFormErrors(1);
    }

    public function testResetPasswordBlockUnknownEmails(): void
    {
        $crawler = $this->client->request('GET', '/password/request');
        $this->expectFormErrors(0);
        $form = $crawler->selectButton('Suivant')->form();
        $form->setValues([
            'request_reset_password_form[email]' => 'unknown@email.com',
        ]);
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->expectErrorAlert();
    }

    public function testResetPasswordShouldSendAnEmail(): void
    {
        /** @var array<string,User> $users */
        $users = $this->loadFixtures(['users']);

        $crawler = $this->client->request('GET', '/password/request');
        $form = $crawler->selectButton('Suivant')->form();
        $form->setValues([
            'request_reset_password_form[email]' => $users['user1']->getEmail(),
        ]);
        $this->client->submit($form);
        $this->assertEmailCount(1);
        $this->client->followRedirect();
        $this->expectFormErrors(0);
    }

    public function testResetPasswordShouldBlockRepeat(): void
    {
        /** @var array<string,User> $users */
        $users = $this->loadFixtures(['users']);

        for ($i = 0; $i <= 2; ++$i) {
            $crawler = $this->client->request('GET', '/password/request');
            $form = $crawler->selectButton('Suivant')->form();
            $form->setValues([
                'request_reset_password_form[email]' => $users['user1']->getEmail(),
            ]);
            $this->client->submit($form);
            $this->client->followRedirect();
        }

        $this->expectErrorAlert();
    }

    public function testResetPasswordConfirmChangePassword(): void
    {
        /** @var array<string, ResetPasswordToken> $tokens */
        $tokens = $this->loadFixtures(['reset_password_token']);

        /** @var ResetPasswordToken $token */
        $token = $tokens['recent_password_token'];
        $this->client->request('GET', "/password/confirm/{$token->getToken()}");
        $this->client->submitForm('Réinitialiser', [
            'confirm_reset_password_form[password][first]' => 'pazjejoazuaziuaazenonazbfiumqksdmù',
            'confirm_reset_password_form[password][second]' => 'pazjejoazuaziuaazenonazbfiumqksdmù',
        ]);

        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->expectSuccessAlert();
    }

    public function testResetPasswordConfirmExpired(): void
    {
        /** @var array<string, ResetPasswordToken> $tokens */
        $tokens = $this->loadFixtures(['reset_password_token']);
        /** @var ResetPasswordToken $token */
        $token = $tokens['old_password_token'];

        $this->client->request('GET', "/password/confirm/{$token->getToken()}");
        $this->client->followRedirect();
        $this->expectErrorAlert();
    }
}
