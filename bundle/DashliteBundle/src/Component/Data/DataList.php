<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Data;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class DataList
{
    public string $title = '';
    public string $description = '';
    public string $value;
}
