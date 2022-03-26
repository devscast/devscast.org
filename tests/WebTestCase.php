<?php

declare(strict_types=1);

namespace Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * Class WebTestCase.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    protected KernelBrowser $client;
    protected EntityManagerInterface $em;

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    protected function setUp(): void
    {
        $this->client = self::createClient();
        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);
        $this->em = $em;
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
        parent::setUp();
    }

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    protected function tearDown(): void
    {
        $this->em->clear();
        parent::tearDown();
    }

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function jsonRequest(string $method, string $url, ?array $data = null): string
    {
        $this->client->request($method, $url, [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_Accept' => 'application/json',
        ], $data ? json_encode($data, JSON_THROW_ON_ERROR) : null);

        return $this->client->getResponse()->getContent();
    }

    /**
     * Vérifie si on a un message d'erreur.
     */
    public function expectErrorAlert(): void
    {
        $this->assertEquals(
            1,
            $this->client
                ->getCrawler()
                ->filter('div[class="alert alert-danger"], div[class="alert alert-error"]')
                ->count(),
            'Error Alert mismatch'
        );
    }

    /**
     * Vérifie si on a un message de succès.
     */
    public function expectSuccessAlert(): void
    {
        $this->assertEquals(
            1,
            $this->client
                ->getCrawler()
                ->filter('div[class="alert alert-success"]')
                ->count(),
            'Success Alert mismatch'
        );
    }

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function expectFormErrors(?int $expectedErrors = null): void
    {
        if (null === $expectedErrors) {
            $this->assertTrue(
                $this->client
                    ->getCrawler()
                    ->filter('.form-error-message')
                    ->count() > 0,
                'Form errors mismatch.'
            );
        } else {
            $this->assertEquals(
                $expectedErrors,
                $this->client
                    ->getCrawler()
                    ->filter('.form-error-message')
                    ->count(),
                'Form errors mismatch.'
            );
        }
    }

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function expectH1(string $title): void
    {
        $crawler = $this->client->getCrawler();
        $this->assertEquals(
            $title,
            $crawler->filter('h1')->text(),
            '<h1> mismatch'
        );
    }

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function expectTitle(string $title): void
    {
        $crawler = $this->client->getCrawler();
        $this->assertEquals(
            $title . ' | Devscast Community',
            $crawler->filter('title')->text(),
            '<title> mismatch',
        );
    }

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function login(?UserInterface $user)
    {
        if (null === $user) {
            return;
        }
        $this->client->loginUser($user);
    }

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function setCsrf(string $key): string
    {
        $csrf = uniqid();
        self::getContainer()->get(TokenStorageInterface::class)->setToken($key, $csrf);

        return $csrf;
    }
}
