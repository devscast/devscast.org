<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait OAuthTrait
 * @package Domain\Authentication\Entity
 * @author bernard-ng <bernard@devscast.tech>
 */
trait OAuthTrait
{
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $github_id = null;

    #[ORM\Column(type: 'string', nullable: true)]
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
