<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

/**
 * Trait OAuthTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait OAuthTrait
{
    private ?string $github_id = null;

    private ?string $google_id = null;

    public function getGithubId(): ?string
    {
        return $this->github_id;
    }

    public function setGithubId(?string $githubId): self
    {
        $this->github_id = $githubId;

        return $this;
    }

    public function getGoogleId(): ?string
    {
        return $this->google_id;
    }

    public function setGoogleId(?string $googleId): self
    {
        $this->google_id = $googleId;

        return $this;
    }

    public function useOauth(): bool
    {
        return null !== $this->google_id || null !== $this->github_id;
    }
}
