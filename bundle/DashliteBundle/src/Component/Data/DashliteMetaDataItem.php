<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Data;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class MetaDataItem.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class DashliteMetaDataItem
{
    public ?string $label = null;
    public ?string $value = null;
}
