<?php

declare(strict_types=1);

namespace Infrastructure\Authentication;

use Domain\Authentication\Entity\User;
use Domain\Authentication\ValueObject\Role;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class OAuthService.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class OAuthService
{
    public const SESSION_KEY = 'authentication_oauth_login';
    private readonly Session | SessionInterface $session;

    public function __construct(
        RequestStack $requestStack,
        private readonly NormalizerInterface $normalizer
    ) {
        $this->session = $requestStack->getSession();
    }

    /**
     * @throws ExceptionInterface
     */
    public function persist(ResourceOwnerInterface $resourceOwner): void
    {
        $data = $this->normalizer->normalize($resourceOwner);
        $this->session->set(self::SESSION_KEY, $data);
    }

    public function hydrate(User $user): bool
    {
        /** @var array|null $oauthData */
        $oauthData = $this->session->get(name: self::SESSION_KEY, default: null);
        if (null === $oauthData || ! isset($oauthData['email'])) {
            return false;
        }

        $user
            ->setEmail($oauthData['email'])
            ->setGithubId($oauthData['github_id'] ?? null)
            ->setGoogleId($oauthData['google_id'] ?? null)
            ->setName($oauthData['username'])
            ->setRoles([Role::USER]);

        return true;
    }

    public function getOauthType(): ?string
    {
        /** @var array $oauthData */
        $oauthData = $this->session->get(self::SESSION_KEY);

        return $oauthData ? $oauthData['type'] : null;
    }
}
