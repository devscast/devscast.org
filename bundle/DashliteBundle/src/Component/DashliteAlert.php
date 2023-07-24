<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class DashliteAlert
{
    public string $type = 'icon';
    public string $message;
    public bool $dismissible = false;
    public string $state = 'danger';
    public string $fill = '';
    public string $icon = 'info';
}
