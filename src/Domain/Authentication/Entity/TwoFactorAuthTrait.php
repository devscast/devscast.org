<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

/**
 * Trait TwoFactorAuthTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait TwoFactorAuthTrait
{
    private ?string $email_auth_code = null;

    private bool $is_email_auth_enabled = false;

    private bool $is_google_authenticator_enabled = false;

    private ?string $google_authenticator_secret = null;

    public function isGoogleAuthenticatorEnabled(): bool
    {
        return $this->is_google_authenticator_enabled;
    }

    public function enableGoogleAuthenticator(): self
    {
        $this->is_google_authenticator_enabled = true;

        return $this;
    }

    public function disableGoogleAuthenticator(): self
    {
        $this->is_google_authenticator_enabled = false;

        return $this;
    }

    public function getGoogleAuthenticatorUsername(): string
    {
        return (string) $this->email;
    }

    public function getGoogleAuthenticatorSecret(): string
    {
        return (string) $this->google_authenticator_secret;
    }

    public function setGoogleAuthenticatorSecret(?string $google_authenticator_secret): self
    {
        $this->google_authenticator_secret = $google_authenticator_secret;

        return $this;
    }

    public function getEmailAuthCode(): string
    {
        return (string) $this->email_auth_code;
    }

    public function setEmailAuthCode(string $authCode): void
    {
        $this->email_auth_code = $authCode;
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

    public function is2FAEnabled(): bool
    {
        return $this->is_email_auth_enabled || $this->is_google_authenticator_enabled;
    }
}
