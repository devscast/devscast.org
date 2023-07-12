<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Table\Responsive;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class ResponsiveTableColumn.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class ResponsiveTableColumn
{
    public ?string $value = null;
    public ?string $responsive = null;
    public bool $tools = false;
    public bool $col = false;
}
