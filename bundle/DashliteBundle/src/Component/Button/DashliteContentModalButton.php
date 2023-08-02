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
final class DashliteContentModalButton
{
    public string $name;
    public string $id;
    public ?string $url = null;
    public ?string $action = null;
    public ?string $icon = null;
    public ?string $path = null;
}
