<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Mailing;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class EmailButton.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class EmailButton
{
    public ?string $url = null;
    public ?string $title = null;
    public string $color = 'primary';
    public string $format = 'html';
}
