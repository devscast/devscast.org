<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\Controller;

use Tests\WebTestCase;

final class ResetPasswordControllerTest extends WebTestCase
{
    public function testResetPasswordRequestPageIsAvailable(): void
    {
        $this->client->request('GET', 'password/request');
        $this->assertResponseIsSuccessful();
    }
}
