<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\RegisterUserCommand;
use Application\Authentication\Service\CodeGeneratorService;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Event\UserRegisteredEvent;
use Domain\Authentication\Exception\EmailAlreadyUsedException;
use Domain\Authentication\Exception\UsernameAlreadyUsedException;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * class RegisterUserHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class RegisterUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly UserPasswordHasherInterface $hasher,
        private readonly EventDispatcherInterface $dispatcher,
        private readonly CodeGeneratorService $codeGeneratorService
    ) {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        if ($this->repository->findOneByEmail((string) $command->email)) {
            throw new EmailAlreadyUsedException();
        }

        if ($this->repository->findOneByUsername((string) $command->username)) {
            throw new UsernameAlreadyUsedException();
        }

        $user = (new User())
            ->setUsername((string) $command->username)
            ->setEmail($command->email)
            ->setName($command->name)
            ->setRoles($command->roles)
            ->setIsSubscribedMarketing($command->is_subscribed_marketing)
            ->setIsSubscribedNewsletter($command->is_subscribed_newsletter);

        if ($command->is_oauth) {
            $user->setFacebookId($command->facebook_id)
                ->setGoogleId($command->google_id)
                ->setGithubId($command->github_id);
        } else {
            $user->setEmailVerificationToken($this->codeGeneratorService->generateToken());
            $user->setPassword($this->hasher->hashPassword($user, (string) $command->password));
        }

        $this->repository->save($user);
        $this->dispatcher->dispatch(new UserRegisteredEvent($user, $command->is_oauth, $command->oauth_type));
    }
}
