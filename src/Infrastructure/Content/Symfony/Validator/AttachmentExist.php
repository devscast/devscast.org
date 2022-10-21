<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * class AttachmentExist.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class AttachmentExist extends Constraint
{
    public string $message = "Aucun attachment ne correspond à l'id {{ id }}";
}
