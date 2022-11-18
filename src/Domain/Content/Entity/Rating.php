<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Domain\Authentication\Entity\User;
use Domain\Shared\Entity\AbstractEntity;
use Domain\Shared\Entity\OwnerTrait;

/**
 * class Rating.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Rating extends AbstractEntity
{
    use OwnerTrait;

    final public const UP_VOTE = 1;

    final public const DOWN_VOTE = -1;

    private ?Content $target;

    private int $rating;

    public static function downVote(User $owner, Content $target): self
    {
        return (new self())
            ->setOwner($owner)
            ->setTarget($target)
            ->setRating(self::DOWN_VOTE);
    }

    public static function upVote(User $owner, Content $target): self
    {
        return (new self())
            ->setOwner($owner)
            ->setTarget($target)
            ->setRating(self::UP_VOTE);
    }

    public function getTarget(): ?Content
    {
        return $this->target;
    }

    public function setTarget(?Content $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        if (1 !== $rating && -1 !== $rating) {
            throw new \InvalidArgumentException('expecting 1 or -1 as rating value');
        }

        $this->rating = $rating;

        return $this;
    }
}
