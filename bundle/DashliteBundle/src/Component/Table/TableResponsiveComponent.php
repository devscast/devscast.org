<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Table;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class TableResponsiveComponent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class TableResponsiveComponent
{
    public mixed $data;
}
