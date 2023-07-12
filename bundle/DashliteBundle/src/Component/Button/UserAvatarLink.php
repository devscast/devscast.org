<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Button;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class UserAvatarLink.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class UserAvatarLink
{
    public string $username;
    public string $surname;
    public string $path;
    public ?string $avatarUrl;
}
