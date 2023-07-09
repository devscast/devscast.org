<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Layout;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class Header.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class Header
{
    public string $title;
    public mixed $data;
}
