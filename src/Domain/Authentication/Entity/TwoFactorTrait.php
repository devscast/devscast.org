<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

/**
 * Trait TwoFactorTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait TwoFactorTrait
{
    private ?string $email_auth_code = null;

    private ?string $google_auth_secret = null;

    private ?array $backup_codes = [];

    private bool $is_email_auth_enabled = false;

    private bool $is_google_auth_enabled = false;

    public function isGoogleAuthenticatorEnabled(): bool
    {
        return $this->isIsGoogleAuthEnabled();
    }

    public function enableGoogleAuthenticator(): self
    {
        $this->is_google_auth_enabled = true;

        return $this;
    }

    public function disableGoogleAuthenticator(): self
    {
        $this->is_google_auth_enabled = false;

        return $this;
    }

    public function getGoogleAuthenticatorUsername(): string
    {
        return (string) $this->email;
    }

    public function getGoogleAuthenticatorSecret(): string
    {
        return (string) $this->getGoogleAuthSecret();
    }

    public function getEmailAuthCode(): string
    {
        return (string) $this->email_auth_code;
    }

    public function setEmailAuthCode(string $code): void
    {
        $this->email_auth_code = $code;
    }

    public function isEmailAuthEnabled(): bool
    {
        return $this->is_email_auth_enabled;
    }

    public function enableEmailAuthCode(): self
    {
        $this->is_email_auth_enabled = true;

        return $this;
    }

    public function disableEmailAuthCode(): self
    {
        $this->is_email_auth_enabled = false;

        return $this;
    }

    public function getEmailAuthRecipient(): string
    {
        return (string) $this->email;
    }

    public function isTwoFactorEnabled(): bool
    {
        return $this->is_email_auth_enabled || $this->is_google_auth_enabled;
    }

    public function isBackupCode(string $code): bool
    {
        return in_array((int) $code, $this->getBackupCodes(), true);
    }

    public function setBackupCodes(?array $codes = []): self
    {
        if (null === $codes) {
            $this->backup_codes = [];
        } elseif (6 !== count($codes)) {
            throw new \InvalidArgumentException('Please set 6 backup codes with 6 digits long');
        } else {
            foreach ($codes as $code) {
                if (6 !== strlen((string) $code)) {
                    throw new \InvalidArgumentException('Code should have 6 digits long');
                }
            }
            $this->backup_codes = $codes;
        }

        return $this;
    }

    public function getBackupCodes(): array
    {
        return $this->backup_codes ?? [];
    }

    public function isEmptyBackupCodes(): bool
    {
        return 0 === count((array) $this->backup_codes);
    }

    public function invalidateBackupCode(string $code): void
    {
        $this->backup_codes = array_filter(
            $this->getBackupCodes(),
            fn (string $c) => $c !== $code
        );
    }

    public function getGoogleAuthSecret(): ?string
    {
        return $this->google_auth_secret;
    }

    public function setGoogleAuthSecret(?string $secret): self
    {
        $this->google_auth_secret = $secret;

        return $this;
    }

    public function isIsEmailAuthEnabled(): bool
    {
        return $this->is_email_auth_enabled;
    }

    public function setIsEmailAuthEnabled(bool $enabled): self
    {
        $this->is_email_auth_enabled = $enabled;

        return $this;
    }

    public function isIsGoogleAuthEnabled(): bool
    {
        return $this->is_google_auth_enabled;
    }

    public function setIsGoogleAuthEnabled(bool $enabled): self
    {
        $this->is_google_auth_enabled = $enabled;

        return $this;
    }
}
