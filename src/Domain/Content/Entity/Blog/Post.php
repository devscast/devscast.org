<?php

declare(strict_types=1);

namespace Domain\Content\Entity\Blog;

use Domain\Content\Entity\Content;
use Domain\Content\Enum\ContentType;

/**
 * Class Post.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Post extends Content
{
    private ?Category $category = null;

    public function getContentType(): ContentType
    {
        return ContentType::POST;
    }

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
