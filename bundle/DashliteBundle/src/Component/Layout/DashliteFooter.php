<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Layout;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class Footer.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class DashliteFooter
{
    public string $copyRight;
}
