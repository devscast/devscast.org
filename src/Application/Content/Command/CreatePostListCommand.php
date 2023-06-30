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
        public ?User $owner = null,
        #[Assert\NotBlank] public ?string $description = null,
        public bool $is_public = false
    ) {
    }
}
