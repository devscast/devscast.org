<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\Controller;

use Tests\WebTestCase;

/**
 * class ResetLoginAttemptsControllerTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetLoginAttemptsControllerTest extends WebTestCase
{
    public function testResetLoginAttemptsWithInvalidToken(): void
    {
        $token = 'invalid-token';
        $this->client->request('GET', "/login/unlock/{$token}");

        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->expectErrorAlert();
    }
}
