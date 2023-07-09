<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class Icon.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class Icon
{
    public string $name;
}
