<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Authenticator;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Infrastructure\Authentication\Exception\UserOAuthAuthenticatedException;
use Infrastructure\Authentication\OAuthService;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Scheb\TwoFactorBundle\Security\Http\Authenticator\TwoFactorAuthenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * Class AbstractOAuthAuthenticator.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractOAuthAuthenticator extends OAuth2Authenticator
{
    use TargetPathTrait;

    protected string $serviceName = '';

    public function __construct(
        private readonly ClientRegistry $clientRegistry,
        protected EntityManagerInterface $em,
        private readonly RouterInterface $router,
        private readonly TokenStorageInterface $token,
        private readonly OAuthService $socialLogin,
    ) {
    }

    public function supports(Request $request): bool
    {
        if ('' === $this->serviceName) {
            throw new \InvalidArgumentException(message: "You must set a \$serviceName property (for instance 'github', 'google')");
        }

        return 'authentication_oauth_check' ===
            $request->attributes->get('_route') &&
            $request->get('service') === $this->serviceName;
    }

    public function createToken(Passport $passport, string $firewallName): TokenInterface
    {
        $token = parent::createToken($passport, $firewallName);

        // Set this to bypass 2fa for this authenticator
        $token->setAttribute(TwoFactorAuthenticator::FLAG_2FA_COMPLETE, true);

        return $token;
    }

    public function authenticate(Request $request): Passport
    {
        $credentials = $this->fetchAccessToken($this->getClient());
        $resourceOwner = $this->getResourceOwnerFromCredentials($credentials);
        /** @var UserRepositoryInterface $repository */
        $repository = $this->em->getRepository(User::class);

        $user = $this->getUserOrNull();
        if ($user) {
            throw new UserOAuthAuthenticatedException($user, $resourceOwner);
        }

        return new SelfValidatingPassport(
            userBadge: new UserBadge(
                userIdentifier: strval($resourceOwner->getId()),
                userLoader: function () use ($resourceOwner, $repository) {
                    $user = $this->getUserFromResourceOwner(
                        resourceOwner: $resourceOwner,
                        repository: $repository
                    );

                    // register the user
                    if (null === $user) {
                        $this->socialLogin->persist($resourceOwner);
                        $user = new User();
                        if ($this->socialLogin->hydrate($user)) {
                            $this->em->persist($user);
                            $this->em->flush();
                        }
                    }

                    return $user;
                }
            )
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): RedirectResponse
    {
        if ($exception instanceof UserOAuthAuthenticatedException) {
            return new RedirectResponse($this->router->generate('authentication_login'));
        }

        if ($request->hasSession()) {
            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        }

        return new RedirectResponse($this->router->generate('authentication_login'));
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName
    ): RedirectResponse {
        $redirect = strval($request->get('_redirect'));
        if ($redirect) {
            $this->router->match($redirect);

            return new RedirectResponse($redirect);
        }

        $targetPath = $this->getTargetPath($request->getSession(), $firewallName);
        if ($targetPath) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->router->generate('app_index'));
    }

    protected function getResourceOwnerFromCredentials(AccessToken $credentials): ResourceOwnerInterface
    {
        return $this->getClient()->fetchUserFromToken($credentials);
    }

    abstract protected function getUserFromResourceOwner(
        ResourceOwnerInterface $resourceOwner,
        UserRepositoryInterface $repository
    ): ?User;

    private function getClient(): OAuth2ClientInterface
    {
        return $this->clientRegistry->getClient($this->serviceName);
    }

    private function getUserOrNull(): ?User
    {
        $token = $this->token->getToken();
        if (! $token) {
            return null;
        }

        $user = $token->getUser();
        if (! \is_object($user) || ! $user instanceof User) {
            return null;
        }

        return $user;
    }
}
