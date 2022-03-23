<?php

declare(strict_types=1);

namespace Infrastructure\Authentication;

use Domain\Authentication\Entity\User;
use Domain\Authentication\ValueObject\Role;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class OAuthService
 * @package Infrastructure\Authentication
 * @author bernard-ng <bernard@devscast.tech>
 */
final class OAuthService
{
    public const SESSION_KEY = 'authentication_oauth_login';
    private Session|SessionInterface $session;

    public function __construct(RequestStack $requestStack, private NormalizerInterface $normalizer)
    {
        $this->session = $requestStack->getSession();
    }

    public function persist(ResourceOwnerInterface $resourceOwner): void
    {
        $data = $this->normalizer->normalize($resourceOwner);
        $this->session->set(self::SESSION_KEY, $data);
    }

    public function hydrate(User $user): bool
    {
        /** @var array $oauthData */
        $oauthData = $this->session->get(self::SESSION_KEY);
        if (null == $oauthData || !isset($oauthData['email'])) {
            return false;
        }

        $user->setEmail($oauthData['email']);
        $user->setGithubId($oauthData['github_id'] ?? null);
        $user->setGoogleId($oauthData['google_id'] ?? null);
        $user->setName($oauthData['username']);
        $user->setRoles([Role::USER]);
        return true;
    }

    public function getOauthType(): ?string
    {
        /** @var array $oauthData */
        $oauthData = $this->session->get(self::SESSION_KEY);
        return $oauthData ? $oauthData['type'] : null;
    }
}
