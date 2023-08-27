<?php

declare(strict_types=1);

namespace Infrastructure\Authentication;

use Application\Authentication\Command\RegisterUserCommand;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class OAuthRegistrationService.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class OAuthRegistrationService
{
    public const SESSION_KEY = 'auth_oauth_login';

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly NormalizerInterface $normalizer
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function persist(ResourceOwnerInterface $resourceOwner): void
    {
        $data = $this->normalizer->normalize($resourceOwner);
        $this->requestStack->getSession()->set(self::SESSION_KEY, $data);
    }

    public function desist(): void
    {
        $this->requestStack->getSession()->remove(self::SESSION_KEY);
    }

    public function hydrate(RegisterUserCommand $command): bool
    {
        /** @var array|null $oauthData */
        $oauthData = $this->requestStack->getSession()->get(name: self::SESSION_KEY);
        if (null === $oauthData || ! isset($oauthData['email'])) {
            return false;
        }

        $command->name = $oauthData['username'];
        $command->email = $oauthData['email'];
        $command->facebook_id = $oauthData['facebook_id'] ?? null;
        $command->google_id = $oauthData['google_id'] ?? null;
        $command->github_id = $oauthData['github_id'] ?? null;
        $command->oauth_type = $oauthData['type'] ?? null;
        $command->is_oauth = true;

        return true;
    }

    public function getOauthType(): ?string
    {
        /** @var array $oauthData */
        $oauthData = $this->requestStack->getSession()->get(self::SESSION_KEY);

        return $oauthData ? $oauthData['type'] : null;
    }
}
