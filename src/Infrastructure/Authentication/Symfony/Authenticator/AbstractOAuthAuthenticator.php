<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Authenticator;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Exception\UserOAuthAuthenticatedException;
use Domain\Authentication\Exception\UserOAuthNotFoundException;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Infrastructure\Authentication\OAuthRegistrationService;
use Infrastructure\Authentication\Symfony\DomainAuthenticationExceptionTrait;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Scheb\TwoFactorBundle\Security\Http\Authenticator\TwoFactorAuthenticator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
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
    use DomainAuthenticationExceptionTrait;

    protected string $serviceName = '';

    public function __construct(
        private readonly ClientRegistry $clientRegistry,
        protected EntityManagerInterface $em,
        private readonly RouterInterface $router,
        private readonly TokenStorageInterface $token,
        private readonly OAuthRegistrationService $OAuthRegistrationService,
    ) {
    }

    public function supports(Request $request): bool
    {
        if ('' === $this->serviceName) {
            throw new \InvalidArgumentException(message: "You must set a \$serviceName property (for instance 'github', 'google', 'facebook')");
        }

        return 'auth_oauth_check' ===
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
        $user = $this->getUserOrNull();
        if (null !== $user) {
            $this->throwDomainException(new UserOAuthAuthenticatedException($user, $resourceOwner));
        }

        /** @var UserRepositoryInterface $repository */
        $repository = $this->em->getRepository(User::class);
        $user = $this->getUserFromResourceOwner($resourceOwner, $repository);
        if (null === $user) {
            $this->OAuthRegistrationService->persist($resourceOwner);
            $this->throwDomainException(new UserOAuthNotFoundException($resourceOwner));
        }

        return new SelfValidatingPassport(
            userBadge: new UserBadge($user->getUserIdentifier(), fn () => $user),
            badges: [
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): RedirectResponse
    {
        if ($exception->getPrevious() instanceof UserOAuthNotFoundException) {
            return new RedirectResponse($this->router->generate('auth_register', [
                'oauth' => 1,
            ]));
        }

        if ($request->hasSession()) {
            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        }

        return new RedirectResponse($this->router->generate('auth_login'));
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName
    ): RedirectResponse {
        /** @var string $redirect */
        $redirect = $request->get('_redirect');
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
