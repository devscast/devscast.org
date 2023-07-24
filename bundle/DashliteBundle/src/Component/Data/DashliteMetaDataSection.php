<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Data;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class MetaDataSection.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class DashliteMetaDataSection
{
    public ?string $title = null;
    public bool $row = false;
}
