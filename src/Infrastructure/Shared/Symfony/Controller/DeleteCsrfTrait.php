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
    public function isDeleteCsrfTokenValid(string $id, Request $request): bool
    {
        return $this->isCsrfTokenValid(
            "delete_{$id}",
            (string) $request->request->get('_token')
        );
    }
}
