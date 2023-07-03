<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Layout;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class HeaderComponent
{
    public string $title;
    public mixed $data;
}
