<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Trait DeleteCsrfTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait DeleteCsrfTrait
{
    public function isDeleteCsrfTokenValid(object $entity, Request $request): bool
    {
        if (method_exists($entity, 'getId')) {
            $id = $entity->getId();

            return $this->isCsrfTokenValid(
                "delete_{$id}",
                (string) $request->request->get('_token')
            );
        }

        throw new \RuntimeException('$entity should have a getId method !');
    }
}
