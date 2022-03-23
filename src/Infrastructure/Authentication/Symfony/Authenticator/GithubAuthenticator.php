<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Authenticator;

use Domain\Authentication\Repository\UserRepository;
use Domain\Authentication\Entity\User;
use Infrastructure\Authentication\Exception\OAuthVerifiedEmailNotFoundException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Retry\GenericRetryStrategy;
use Symfony\Component\HttpClient\RetryableHttpClient;

/**
 * Class GithubAuthenticator
 * @package Infrastructure\Authentication\Symfony\Authenticator
 * @author bernard-ng <bernard@devscast.tech>
 */
final class GithubAuthenticator extends AbstractOAuthAuthenticator
{
    protected string $serviceName = 'github';

    public function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UserRepository $repository): ?User
    {
        if (!($resourceOwner instanceof GithubResourceOwner)) {
            throw new \RuntimeException('Expecting GithubResourceOwner as the first parameter');
        }

        $user = $repository->findForOauth(
            service: 'github',
            serviceId: (string)$resourceOwner->getId(),
            email: $resourceOwner->getEmail()
        );

        if ($user && null === $user->getGithubId()) {
            $user->setGithubId((string)$resourceOwner->getId());
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
        $emails = json_decode($response->getContent(), true);
        foreach ($emails as $email) {
            if (true === $email['primary'] && true === $email['verified']) {
                $data = $githubUser->toArray();
                $data['email'] = $email['email'];

                return new GithubResourceOwner($data);
            }
        }

        throw new OAuthVerifiedEmailNotFoundException();
    }
}
