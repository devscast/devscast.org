<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Card;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class Modal.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class DashliteContentModal
{
    public string $id;
    public string $url;
    public ?string $action = null;
    public string $position = 'bottom';
    public string $size = 'lg';
}
