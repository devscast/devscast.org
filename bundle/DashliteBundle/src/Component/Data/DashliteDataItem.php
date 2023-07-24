<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Data;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class DashliteDataItem
{
    public string $style = 'wider';
    public string $label;
    public ?string $value;
    public bool $link = false;
}
