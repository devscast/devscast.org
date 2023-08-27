<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Mailing;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class EmailQrCode.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DashliteEmailQrCode
{
    public string $title = '';
    public string $src = '';
    public string $format = 'html';
}
