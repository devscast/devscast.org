<?php

declare(strict_types=1);

namespace Application\Content\Command\Blog;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreateCategoryCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateCategoryCommand
{
    public function __construct(
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $description = null,
    ) {
    }
}
