<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Button;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class DeleteButton.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class FormModalButton
{
    public string $name;
    public string $icon;
    public ?string $path;
}
