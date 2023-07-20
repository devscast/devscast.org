<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Mailing;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class EmailAlert.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class EmailAlert
{
    public string $message;
    public ?string $format = 'html';
}
