<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Validator;

use Domain\Content\Entity\Blog\Attachment;
use Symfony\Component\Uid\Uuid;

/**
 * class NonExistingAttachment.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class NonExistingAttachment extends Attachment
{
    public function __construct(Uuid $expectedId)
    {
        $this->setId($expectedId);
        parent::__construct();
    }
}
