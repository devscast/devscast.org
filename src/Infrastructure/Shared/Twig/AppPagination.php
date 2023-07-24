<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class AppPagination.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(name: 'AppPagination', template: '@app/shared/component/pagination.html.twig')]
final class AppPagination
{
    public SlidingPaginationInterface $data;

    public function mount(SlidingPaginationInterface $data): void
    {
        $this->data = $data;
    }
}
