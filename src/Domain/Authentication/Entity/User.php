<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package App\Domain\Authentication\Entity
 * @author bernard-ng <bernard@devscast.tech>
 */
final class User implements UserPasswordHasherInterface, UserInterface
{
    use OAuthTrait;

    public function getEmail(): string
    {
        return '';
    }

    public function setEmail(string $email): self
    {
        return $this;
    }

    public function getName(): ?string
    {
        return '';
    }

    public function setName(string $name): self
    {
        return $this;
    }

    public function setRoles(array $array)
    {
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    public function hashPassword(PasswordAuthenticatedUserInterface $user, string $plainPassword): string
    {
        return '';
    }

    public function isPasswordValid(PasswordAuthenticatedUserInterface $user, string $plainPassword): bool
    {
        return true;
    }

    public function needsRehash(PasswordAuthenticatedUserInterface $user): bool
    {
        return false;
    }
}
