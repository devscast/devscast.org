<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\Controller;

use Domain\Authentication\Entity\User;
use Tests\FixturesTrait;
use Tests\WebTestCase;

/**
 * Class LoginLinkControllerTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginLinkControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function testLoginLinkRequestPageIsAvailable(): void
    {
        $this->client->request('GET', '/login/link/request');
        $this->assertResponseIsSuccessful();
    }

    public function testLoginLinkIsReachableFromLoginForm(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $this->client->click($crawler->selectLink('Mot de passe oublie ?')->link());
        $this->expectTitle('Un Problème de connexion ?');
    }

    public function testLoginLinkBlockBadEmails(): void
    {
        $crawler = $this->client->request('GET', '/login/link/request');
        $this->expectFormErrors(0);
        $form = $crawler->selectButton('Suivant')->form();
        $form->setValues([
            'request_login_link_form[email]' => 'invalid',
        ]);
        $this->client->submit($form);
        $this->expectFormErrors(1);
    }

    public function testLoginLinkBlockNotAssignedEmails(): void
    {
        $crawler = $this->client->request('GET', '/login/link/request');
        $form = $crawler->selectButton('Suivant')->form();
        $form->setValues([
            'request_login_link_form[email]' => 'none@none.com',
        ]);
        $this->client->submit($form);
        $this->expectErrorAlert();
    }

    public function testLoginLinkRequestShouldSendAnEmail(): void
    {
        /** @var array<string,User> $users */
        $users = $this->loadFixtures(['users']);

        $crawler = $this->client->request('GET', '/login/link/request');
        $form = $crawler->selectButton('Suivant')->form();
        $form->setValues([
            'request_login_link_form[email]' => $users['user1']->getEmail(),
        ]);
        $this->client->submit($form);
        $this->expectFormErrors(0);
        $this->assertEmailCount(1);
    }
}
