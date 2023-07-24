<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Mailing;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class EmailSection.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class DashliteEmailSection
{
    public string $title = '';
    public string $url = '';
    public string $format = 'html';
}
