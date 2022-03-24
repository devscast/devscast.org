<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Domain\Authentication\Repository\ResetPasswordTokenRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Domain\Shared\Entity\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package App\Domain\Authentication\Entity
 * @author bernard-ng <bernard@devscast.tech>
 */
#[ORM\Entity(repositoryClass: ResetPasswordTokenRepository::class)]
#[ORM\HasLifecycleCallbacks]
final class User implements UserInterface, PasswordAuthenticatedUserInterface
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

    public function setRoles(array $array): self
    {
        return $this;
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

    public function getPassword(): ?string
    {
        return '';
    }
}
