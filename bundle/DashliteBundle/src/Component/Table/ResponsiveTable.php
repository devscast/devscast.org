<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Table;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class ResponsiveTable.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class ResponsiveTable
{
    public mixed $data;
    public ?string $emptyStatePath = null;
    public ?string $emptyStateAction = null;
    public bool $separated = true;
}
