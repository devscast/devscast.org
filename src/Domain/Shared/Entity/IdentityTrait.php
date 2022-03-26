<?php

declare(strict_types=1);

namespace Domain\Shared\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait IdentityTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait IdentityTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
