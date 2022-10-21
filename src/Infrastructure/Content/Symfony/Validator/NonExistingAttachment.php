<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Validator;

use Domain\Content\Entity\Attachment;
use Symfony\Component\Validator\Constraint;

/**
 * class NonExistingAttachment.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class NonExistingAttachment extends Attachment
{
    public function __construct(int $expectedId)
    {
        $this->setId($expectedId);
        parent::__construct();
    }
}
