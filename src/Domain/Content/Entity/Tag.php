<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\TimestampTrait;

/**
 * Class Tag.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Tag
{
    use IdentityTrait;
    use TimestampTrait;

    private ?string $name = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
