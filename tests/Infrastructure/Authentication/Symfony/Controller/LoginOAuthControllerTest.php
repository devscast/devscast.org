<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\Controller;

use Domain\Authentication\Entity\User;
use Tests\FixturesTrait;
use Tests\WebTestCase;

/**
 * Class LoginOAuthController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginOAuthControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function testDisconnectGoogleOAuthService(): void
    {
        /** @var User $user */
        ['user_oauth_google' => $user] = $this->loadFixtures(['users']);
        $this->login($user);

        $this->assertNotNull($user->getGoogleId());
        $this->client->request('POST', '/login/oauth/disconnect/google');
        $this->assertResponseRedirects('/', 302);
        $this->assertNull($user->getGoogleId());
    }

    public function testDisconnectGithubOAuthService(): void
    {
        /** @var User $user */
        ['user_oauth_github' => $user] = $this->loadFixtures(['users']);
        $this->login($user);

        $this->assertNotNull($user->getGithubId());
        $this->client->request('POST', '/login/oauth/disconnect/github');
        $this->assertResponseRedirects('/', 302);
        $this->assertNull($user->getGithubId());
    }

    public function testCheckOAuthServiceIsAvailable(): void
    {
        $services = ['github', 'google'];
        foreach ($services as $service) {
            $this->client->request('POST', "/login/oauth/check/{$service}");
            $this->assertResponseRedirects('/login', 302);
        }
    }
}
