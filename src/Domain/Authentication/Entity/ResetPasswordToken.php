<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Domain\Authentication\Repository\ResetPasswordTokenRepository;
use Domain\Shared\Entity\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ResetPasswordToken
 * @package Domain\Authentication\Entity
 * @author bernard-ng <bernard@devscast.tech>
 */
#[ORM\Entity(repositoryClass: ResetPasswordTokenRepository::class)]
#[ORM\HasLifecycleCallbacks]
final class ResetPasswordToken
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $token = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function isExpired(int $interval): bool
    {
        try {
            $expirationDate = new \DateTime('-' . $interval . ' minutes');
            return $this->getCreatedAt() < $expirationDate;
        } catch (\Exception $e) {
            return false;
        }
    }
}
