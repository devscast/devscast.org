<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

/**
 * Class Post.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Post extends Content
{
    private ?Category $category = null;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
