<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Card;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class ModalComponent
{
    public string $action;
    public string $path;
}
