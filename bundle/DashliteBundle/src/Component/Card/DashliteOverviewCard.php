<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Card;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class OverviewCard.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
class DashliteOverviewCard
{
    public string $label;
    public ?float $value = null;
    public ?float $ratio = null;
    public ?string $chart = null;
    public ?string $info = 'Aucun changement';
}
