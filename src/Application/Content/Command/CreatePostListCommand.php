<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreatePostListCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreatePostListCommand
{
    public function __construct(
        public readonly User $owner,
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $description = null,
        public bool $is_public = false
    ) {
    }
}
