<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Domain\Authentication\ValueObject\Gender;
use Domain\Authentication\ValueObject\Roles;
use Domain\Authentication\ValueObject\Username;
use Domain\Shared\Entity\{IdentityTrait, TimestampTrait};
use Scheb\TwoFactorBundle\Model\BackupCodeInterface as BackupCodesTwoFactor;
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
class User implements UserInterface, PasswordAuthenticatedUserInterface, GoogleTwoFactor, EmailTwoFactor, BackupCodesTwoFactor
{
    use OAuthTrait;
    use TwoFactorTrait;
    use IdentityTrait;
    use TimestampTrait;

    private ?string $name = null;

    private ?Username $username = null;

    private ?string $job_title = null;

    private ?string $biography = null;

    private Gender $gender;

    private ?string $pronouns = null;

    private ?string $email = null;

    private ?string $phone_number = null;

    private ?string $country = null;

    private Roles $roles;

    private ?string $password = null;

    private bool $is_email_verified = false;

    private bool $is_phone_number_verified = false;

    private bool $is_banned = false;

    private ?string $reset_login_attempts_token = null;

    private ?string $email_verification_token = null;

    private ?string $phone_number_verification_token = null;

    private bool $is_subscribed_newsletter = false;

    private bool $is_subscribed_marketing = false;

    private ?\DateTimeImmutable $banned_at = null;

    private ?\DateTimeImmutable $last_login_at = null;

    private ?string $last_login_ip = null;

    public function __construct()
    {
        $this->gender = Gender::male();
        $this->roles = Roles::developer();
    }

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
            ->setRoles($is_admin ? Roles::admin() : Roles::developer());
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

    public function getUsername(): ?Username
    {
        return $this->username;
    }

    public function setUsername(Username|string $username): self
    {
        if ($username instanceof Username) {
            $this->username = $username;
        } else {
            $this->username = Username::fromString($username);
        }

        return $this;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function setGender(Gender|string $gender): self
    {
        if ($gender instanceof Gender) {
            $this->gender = $gender;
        } else {
            $this->gender = Gender::fromString($gender);
        }

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
        return $this->roles->toArray();
    }

    public function setRoles(Roles|array $roles): self
    {
        if ($roles instanceof Roles) {
            $this->roles = $roles;
        } else {
            $this->roles = Roles::fromArray($roles);
        }

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

    public function isIsEmailVerified(): bool
    {
        return $this->is_email_verified;
    }

    public function setIsEmailVerified(bool $is_email_verified): self
    {
        $this->is_email_verified = $is_email_verified;

        return $this;
    }

    public function isIsPhoneNumberVerified(): bool
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

    public function getPronouns(): ?string
    {
        return $this->pronouns;
    }

    public function setPronouns(string $pronouns): self
    {
        $this->pronouns = $pronouns;

        return $this;
    }

    public function isConfirmed(): bool
    {
        return $this->is_email_verified || $this->is_phone_number_verified || $this->useOauth();
    }

    public function isIsSubscribedNewsletter(): bool
    {
        return $this->is_subscribed_newsletter;
    }

    public function setIsSubscribedNewsletter(bool $is_subscribed_newsletter): self
    {
        $this->is_subscribed_newsletter = $is_subscribed_newsletter;

        return $this;
    }

    public function isIsSubscribedMarketing(): bool
    {
        return $this->is_subscribed_marketing;
    }

    public function setIsSubscribedMarketing(bool $is_subscribed_marketing): self
    {
        $this->is_subscribed_marketing = $is_subscribed_marketing;

        return $this;
    }

    public function getEmailVerificationToken(): ?string
    {
        return $this->email_verification_token;
    }

    public function setEmailVerificationToken(?string $token): self
    {
        $this->email_verification_token = $token;

        return $this;
    }

    public function getPhoneNumberVerificationToken(): ?string
    {
        return $this->phone_number_verification_token;
    }

    public function setPhoneNumberVerificationToken(?string $token): self
    {
        $this->phone_number_verification_token = $token;

        return $this;
    }

    public function getResetLoginAttemptsToken(): ?string
    {
        return $this->reset_login_attempts_token;
    }

    public function setResetLoginAttemptsToken(?string $token): self
    {
        $this->reset_login_attempts_token = $token;

        return $this;
    }
}
