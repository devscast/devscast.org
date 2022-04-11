<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Domain\Authentication\ValueObject\Role;
use Domain\Shared\Entity\{IdentityTrait, TimestampTrait};
use Scheb\TwoFactorBundle\Model\BackupCodeInterface;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface as EmailTwoFactor;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface as GoogleTwoFactor;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @TODO find a way to remove symfony interfaces from the domain model user
 * Class User
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface, GoogleTwoFactor, EmailTwoFactor, BackupCodeInterface
{
    use IdentityTrait;
    use TimestampTrait;
    use OAuthTrait;
    use TwoFactorAuthTrait;
    use BackupAuthTrait;

    private ?string $name = null;

    private ?string $username = null;

    private ?string $job_title = null;

    private ?string $biography = null;

    private ?string $gender = 'M';

    private ?string $email = null;

    private ?string $phone_number = null;

    private ?string $country = null;

    private array $roles = [Role::USER];

    private ?string $password = null;

    private bool $is_email_verified = false;

    private bool $is_phone_number_verified = false;

    private bool $is_banned = false;

    private ?\DateTimeImmutable $banned_at = null;

    private ?\DateTimeImmutable $last_login_at = null;

    private ?string $last_login_ip = null;

    public static function createBasicWithRequiredFields(
        string $username,
        string $email,
        string $password,
        bool $is_admin = false
    ): self {
        return (new self())
            ->setUsername($username)
            ->setEmail($email)
            ->setPassword($password)
            ->setIsEmailVerified(true)
            ->setRoles([$is_admin ? Role::ADMIN : Role::USER]);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = Role::USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsEmailVerified(): bool
    {
        return $this->is_email_verified;
    }

    public function setIsEmailVerified(bool $is_email_verified): self
    {
        $this->is_email_verified = $is_email_verified;

        return $this;
    }

    public function getIsPhoneNumberVerified(): bool
    {
        return $this->is_phone_number_verified;
    }

    public function setIsPhoneNumberVerified(bool $is_phone_number_verified): self
    {
        $this->is_phone_number_verified = $is_phone_number_verified;

        return $this;
    }

    public function isBanned(): bool
    {
        return $this->is_banned;
    }

    public function setIsBanned(bool $is_banned): self
    {
        $this->is_banned = $is_banned;

        return $this;
    }

    public function getLastLoginAt(): ?\DateTimeImmutable
    {
        return $this->last_login_at;
    }

    public function setLastLoginAt(?\DateTimeInterface $last_login_at): self
    {
        if (null !== $last_login_at) {
            $this->last_login_at = \DateTimeImmutable::createFromInterface($last_login_at);
        } else {
            $this->last_login_at = null;
        }

        return $this;
    }

    public function getLastLoginIp(): ?string
    {
        return $this->last_login_ip;
    }

    public function setLastLoginIp(?string $last_login_ip): self
    {
        $this->last_login_ip = $last_login_ip;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * @inheritDoc
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->getEmail();
    }

    public function getJobTitle(): ?string
    {
        return $this->job_title;
    }

    public function setJobTitle(?string $job_title): self
    {
        $this->job_title = $job_title;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getBannedAt(): ?\DateTimeInterface
    {
        return $this->banned_at;
    }

    public function setBannedAt(?\DateTimeInterface $banned_at): self
    {
        if (null !== $banned_at) {
            $this->banned_at = \DateTimeImmutable::createFromInterface($banned_at);
        } else {
            $this->banned_at = null;
        }

        return $this;
    }

    public function isConfirmed(): bool
    {
        return $this->is_email_verified || $this->is_phone_number_verified;
    }
}
