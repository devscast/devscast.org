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
final class Modal
{
    public string $action;
    public string $path;
}
