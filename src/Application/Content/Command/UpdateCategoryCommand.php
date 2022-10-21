<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Content\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UpdateCategoryCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateCategoryCommand
{
    public function __construct(
        public readonly Category $category,
        #[Assert\NotBlank] public ?string $name = null,
        #[Assert\Length(min: 10)] public ?string $description = null
    ) {
        Mapper::hydrate($this->category, $this);
    }
}
