<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Trait PaginationAssertionTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait PaginationAssertionTrait
{
    protected function assertIsGreaterThanZero(mixed $page): void
    {
        if (! is_int($page) || $page <= 0) {
            throw new BadRequestHttpException();
        }
    }

    protected function assertNonEmptyData(int $page, \Countable $data): void
    {
        if ($page > 1 && 0 === $data->count()) {
            throw new NotFoundHttpException();
        }
    }
}
