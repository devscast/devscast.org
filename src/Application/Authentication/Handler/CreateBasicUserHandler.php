<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\CreateBasicUserCommand;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class CreateBasicUserHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateBasicUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly UserPasswordHasherInterface $hasher
    ) {
    }

    public function __invoke(CreateBasicUserCommand $command): void
    {
        $this->assertUserHasUniqueIdentifiers($command->email, $command->username);
        $user = User::createBasicWithRequiredFields(
            username: $command->username,
            email: $command->email,
            password: $command->password,
            is_admin: $command->is_admin
        );
        $user->setPassword($this->hasher->hashPassword($user, (string) $user->getPassword()));
        $this->repository->save($user);
    }

    private function assertUserHasUniqueIdentifiers(string $email, string $username): void
    {
        $existingEmail = $this->repository->findOneByEmail($email);
        $existingUsername = $this->repository->findOneByUsername($username);

        if (null !== $existingEmail) {
            throw new \RuntimeException(sprintf('email "%s" is already used.', $email));
        }

        if (null !== $existingUsername) {
            throw new \RuntimeException(sprintf('username "%s" is already used.', $username));
        }
    }
}
