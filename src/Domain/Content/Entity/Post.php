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

    private ?PostSeries $series = null;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSeries(): ?PostSeries
    {
        return $this->series;
    }

    public function setSeries(?PostSeries $series): self
    {
        $this->series = $series;

        return $this;
    }
}
