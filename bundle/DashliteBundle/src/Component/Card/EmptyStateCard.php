<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Card;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class EmptyStateCard.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class EmptyStateCard
{
    public ?string $action = null;
    public ?string $path = null;
    public ?string $label = null;
}
