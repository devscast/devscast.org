<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * class AttachmentExistValidator.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class AttachmentExistValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (! $value instanceof NonExistingAttachment) {
            return;
        }

        $this->context
            ->buildViolation($constraint->message ?? "Aucun attachment ne correspond à l'id {{ id }}")
            ->setParameter('{{ id }}', (string) $value->getId())
            ->addViolation();
    }
}
