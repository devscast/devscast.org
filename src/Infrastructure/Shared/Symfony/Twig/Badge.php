<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Twig;

/**
 * Class Badge.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Badge
{
    public const STYLES = [
        'dim' => 'dim',
        'dot' => 'dot',
    ];

    public const STATES = [
        'primary' => 'primary',
        'secondary' => 'secondary',
        'success' => 'success',
        'danger' => 'danger',
        'warning' => 'warning',
        'info' => 'info',
        'dark' => 'dark',
        'grey' => 'grey',
        'light' => 'light',
    ];
}
