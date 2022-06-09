<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Authenticator;

use Domain\Authentication\Entity\User;
use Domain\Authentication\Exception\OAuthVerifiedEmailNotFoundException;
use Domain\Authentication\Repository\UserRepositoryInterface;
use League\OAuth2\Client\Provider\GithubResourceOwner;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Retry\GenericRetryStrategy;
use Symfony\Component\HttpClient\RetryableHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class GithubAuthenticator.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class GithubAuthenticator extends AbstractOAuthAuthenticator
{
    protected string $serviceName = 'github';

    public function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UserRepositoryInterface $repository): ?User
    {
        if (! ($resourceOwner instanceof GithubResourceOwner)) {
            throw new \RuntimeException('Expecting GithubResourceOwner as the first parameter');
        }

        $user = $repository->findForOauth(
            service: 'github',
            serviceId: (string) $resourceOwner->getId(),
            email: $resourceOwner->getEmail()
        );

        if ($user && null === $user->getGithubId()) {
            $user->setGithubId((string) $resourceOwner->getId());
            $this->em->flush();
        }

        return $user;
    }

    public function getResourceOwnerFromCredentials(AccessToken $credentials): GithubResourceOwner
    {
        /** @var GithubResourceOwner $githubUser */
        $githubUser = parent::getResourceOwnerFromCredentials($credentials);
        $client = new RetryableHttpClient(
            client: HttpClient::create(),
            strategy: new GenericRetryStrategy(delayMs: 500),
            maxRetries: 3
        );

        try {
            $response = $client->request(
                method: 'GET',
                url: 'https://api.github.com/user/emails',
                options: [
                    'headers' => [
                        'authorization' => "token {$credentials->getToken()}",
                    ],
                ]
            );

            /** @var array $emails */
            $emails = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
            foreach ($emails as $email) {
                if (true === $email['primary'] && true === $email['verified']) {
                    $data = $githubUser->toArray();
                    $data['email'] = $email['email'];

                    return new GithubResourceOwner($data);
                }
            }

            throw new OAuthVerifiedEmailNotFoundException();
        } catch (
            TransportExceptionInterface |
            ClientExceptionInterface |
            RedirectionExceptionInterface |
            ServerExceptionInterface
        ) {
            throw new OAuthVerifiedEmailNotFoundException();
        }
    }
}
