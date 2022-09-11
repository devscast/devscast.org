<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\Controller;

use Domain\Authentication\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;
use Tests\FixturesTrait;
use Tests\WebTestCase;

/**
 * class RegistrationControllerTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RegistrationControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function testRegistrationPageIsAvailable(): void
    {
        $this->client->request('GET', '/register');
        $this->assertResponseIsSuccessful();
    }

    public function testLoginIsReachableFromRegistrationForm(): void
    {
        $crawler = $this->client->request('GET', '/register');
        $this->client->click($crawler->selectLink("J'ai déjà un compte")->link());
        $this->expectTitle('Connexion');
    }

    public function testRegistrationWithoutOauth(): void
    {
        $this->client->request('GET', '/register');
        $this->client->submitForm('Soumettre', [
            'register_user_form[username][username]' => 'johndoe',
            'register_user_form[email]' => 'johndoe@johndoe.com',
            'register_user_form[password][first]' => 'pazjejoazuaziuaazenonazbfiumqksdmù',
            'register_user_form[password][second]' => 'pazjejoazuaziuaazenonazbfiumqksdmù',
        ]);
        $this->expectFormErrors(0);
        $this->assertEmailCount(1);
        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->expectSuccessAlert();
    }

    // TODO: fix symfony session unavailable bug
    /*public function testRegistrationWithOauth(): void
    {
        // Simulates an oauth session
        $session = new Session(new MockFileSessionStorage());
        $session->set('authentication_oauth_login', [
            'email' => 'john@doe.fr',
            'github_id' => 123123,
            'type' => 'Github',
            'username' => 'John Doe',
        ]);
        $this->client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));

        $this->client->request('GET', '/register?oauth=1');
        $this->client->submitForm('Soumettre', [
            'register_user_form[username][username]' => 'johndoe2',
        ]);

        $this->expectFormErrors(0);
        $this->assertResponseRedirects('/');
        $this->assertEmailCount(1);
    }*/

    public function testRegistrationWithExistingInformations(): void
    {
        /** @var array<string,User> $users */
        $users = $this->loadFixtures(['users']);
        $this->client->request('GET', '/register');
        $this->client->submitForm('Soumettre', [
            'register_user_form[username][username]' => $users['user1']->getUsername(),
            'register_user_form[email]' => $users['user1']->getEmail(),
            'register_user_form[password][first]' => 'pazjejoazuaziuaazenonazbfiumqksdmù',
            'register_user_form[password][second]' => 'pazjejoazuaziuaazenonazbfiumqksdmù',
        ]);

        $this->expectErrorAlert();
        $this->assertResponseStatusCodeSame(422);
    }

    public function testRegistrationConfirmationWithInvalidToken(): void
    {
        $token = 'invalid-token';
        $this->client->request('GET', "/register/confirm/{$token}");

        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->expectErrorAlert();
    }

    public function testRegistrationConfirmation(): void
    {
        /** @var array<string,User> $users */
        $users = $this->loadFixtures(['users']);
        $user = $users['user_unconfirmed'];

        $this->client->request('GET', "/register/confirm/{$user->getEmailVerificationToken()}");
        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->expectSuccessAlert();
    }

    public function testRedirectIfLogged(): void
    {
        /** @var array<string,User> $users */
        $users = $this->loadFixtures(['users']);
        $this->login($users['user1']);
        $this->client->request('GET', '/register');
        $this->assertResponseRedirects('/');
    }
}
