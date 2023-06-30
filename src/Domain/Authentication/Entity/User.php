<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Devscast\Bundle\DddBundle\Domain\Entity\AbstractEntity;
use Domain\Authentication\ValueObject\Gender;
use Domain\Authentication\ValueObject\Roles;
use Domain\Authentication\ValueObject\RssUrl;
use Domain\Authentication\ValueObject\Username;
use Domain\Shared\ValueObject\EmbeddedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\FileAbstraction\ReplacingFile;

/**
 * @TODO find a way to remove symfony interfaces from the domain model user
 * Class User
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class User extends AbstractEntity implements UserInterface, PasswordAuthenticatedUserInterface, TwoFactorUserInterface
{
    use OAuthTrait;
    use TwoFactorTrait;

    public ?string $linkedin_url = null;

    public ?string $github_url = null;

    public ?string $twitter_url = null;

    public ?string $website_url = null;

    public ?RssUrl $rss_url = null;

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

    private bool $is_dark_theme = true;

    private ?EmbeddedFile $avatar = null;

    private ?File $avatar_file = null;

    public function __construct()
    {
        $this->gender = Gender::male();
        $this->roles = Roles::developer();
        $this->avatar = EmbeddedFile::default();
        //$this->avatar_file = new ReplacingFile(sprintf('%s/public/images/default.png', dirname(__DIR__, 4)));
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
        $this->username = match (true) {
            $username instanceof Username => $username,
            default => Username::fromString($username)
        };

        return $this;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function setGender(Gender|string $gender): self
    {
        $this->gender = match (true) {
            $gender instanceof Gender => $gender,
            default => Gender::fromString($gender)
        };

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

    public function setCountry(?string $country): self
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
        $this->roles = match (true) {
            $roles instanceof Roles => $roles,
            default => Roles::fromArray($roles)
        };

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
        $this->last_login_at = match (true) {
            null !== $last_login_at => \DateTimeImmutable::createFromInterface($last_login_at),
            default => null
        };

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
        $this->banned_at = match (true) {
            null !== $banned_at => \DateTimeImmutable::createFromInterface($banned_at),
            default => null
        };

        return $this;
    }

    public function getPronouns(): ?string
    {
        return $this->pronouns;
    }

    public function setPronouns(?string $pronouns): self
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

    public function getLinkedinUrl(): ?string
    {
        return $this->linkedin_url;
    }

    public function setLinkedinUrl(?string $linkedin_url): self
    {
        $this->linkedin_url = $linkedin_url;

        return $this;
    }

    public function getGithubUrl(): ?string
    {
        return $this->github_url;
    }

    public function setGithubUrl(?string $github_url): self
    {
        $this->github_url = $github_url;

        return $this;
    }

    public function getTwitterUrl(): ?string
    {
        return $this->twitter_url;
    }

    public function setTwitterUrl(?string $twitter_url): self
    {
        $this->twitter_url = $twitter_url;

        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->website_url;
    }

    public function setWebsiteUrl(?string $website_url): self
    {
        $this->website_url = $website_url;

        return $this;
    }

    public function getRssUrl(): ?RssUrl
    {
        return $this->rss_url;
    }

    public function setRssUrl(RssUrl|string|null $rss_url): self
    {
        $this->rss_url = match (true) {
            $rss_url instanceof RssUrl => $rss_url,
            is_string($rss_url) => RssUrl::fromString($rss_url),
            default => null
        };

        return $this;
    }

    public function isIsDarkTheme(): bool
    {
        return $this->is_dark_theme;
    }

    public function setIsDarkTheme(bool $is_dark_theme): self
    {
        $this->is_dark_theme = $is_dark_theme;

        return $this;
    }

    public function getAvatar(): ?EmbeddedFile
    {
        return $this->avatar;
    }

    public function setAvatar(?EmbeddedFile $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAvatarFile(): ?File
    {
        return $this->avatar_file;
    }

    public function setAvatarFile(?File $avatar_file): self
    {
        $this->avatar_file = $avatar_file;
        if ($avatar_file instanceof UploadedFile) {
            $this->setUpdatedAtWithCurrentTime();
        }

        return $this;
    }

    public function getInitials(): ?string
    {
        return mb_strtoupper((string) $this->username)[0];
    }

    public function isAdmin(): bool
    {
        return in_array('ROLE_ADMIN', $this->roles->toArray(), true);
    }

    public function hasRole(string $role): bool
    {
        return $this->roles->contains($role);
    }
}
