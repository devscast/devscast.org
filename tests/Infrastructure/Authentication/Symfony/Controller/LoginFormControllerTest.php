<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\Controller;

use Domain\Authentication\Entity\User;
use Tests\FixturesTrait;
use Tests\WebTestCase;

/**
 * Class LoginFormControllerTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginFormControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function testLoginFormPageIsAvailable(): void
    {
        $this->client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }

    public function testLogin(): void
    {
        /** @var array<string,User> $users */
        $users = $this->loadFixtures(['users']);
        $user = $users['user1'];

        $this->client->request('GET', '/login');
        $this->client->submitForm('Se connecter', [
            'identifier' => (string) $user->getUsername(),
            'password' => '000000',
        ]);
        $this->client->followRedirects();
        $this->assertResponseRedirects('/');
    }

    public function testLoginWithInvalidCredentials(): void
    {
        /** @var array<string,User> $users */
        $users = $this->loadFixtures(['users']);
        $user = $users['user1'];

        $this->client->request('GET', '/login');
        $this->client->submitForm('Se connecter', [
            'identifier' => (string) $user->getUsername(),
            'password' => '000001',
        ]);    // TODO: fix fixtures to generate reset password with old datetime

        $this->client->followRedirects();
        $this->assertResponseRedirects('/login');
    }

    public function testTwoFactorEmailLogin(): void
    {
        /** @var array<string,User> $users */
        $users = $this->loadFixtures(['users']);
        $user = $users['user_two_factor'];

        $this->client->request('GET', '/login');
        $this->client->submitForm('Se connecter', [
            'identifier' => (string) $user->getUsername(),
            'password' => '000000',
        ]);
        $this->client->followRedirects();
        $this->assertEmailCount(1);
        $this->assertResponseRedirects();
    }
}
