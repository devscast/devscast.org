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
final class DeleteButton
{
    public string $path;
    public ?string $redirect = null;
    public string $type = 'icon';
    public string $remove = '.nk-tb-item';
    public object $item;
}
