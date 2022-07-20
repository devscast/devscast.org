<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Domain\Authentication\Entity\User;

/**
 * trait AuthorTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait AuthorTrait
{
    private ?User $author;

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
