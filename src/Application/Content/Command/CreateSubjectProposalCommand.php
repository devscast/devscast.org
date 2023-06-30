<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreateSubjectProposalCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateSubjectProposalCommand
{
    public function __construct(
        public readonly User $owner,
        #[Assert\NotBlank] public ?string $subject = null,
    ) {
    }
}
