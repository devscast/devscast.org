<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\Controller;

use Tests\WebTestCase;

/**
 * Class LoginFormControllerTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginFormControllerTest extends WebTestCase
{
    public function testLoginFormPageIsAvailable(): void
    {
        $this->client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }
}
