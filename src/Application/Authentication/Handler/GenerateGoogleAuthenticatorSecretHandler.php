<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\GenerateGoogleAuthenticatorSecretCommand;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class GenerateGoogleAuthenticatorSecretHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class GenerateGoogleAuthenticatorSecretHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly GoogleAuthenticatorInterface $authenticator
    ) {
    }

    public function __invoke(GenerateGoogleAuthenticatorSecretCommand $command): void
    {
        $user = $command->user;
        $secret = $this->authenticator->generateSecret();

        $user->setGoogleAuthenticatorSecret($secret);
        $this->repository->save($user);
    }
}
