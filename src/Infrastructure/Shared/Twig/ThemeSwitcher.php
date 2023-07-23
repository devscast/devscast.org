<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class ThemeSwitcher.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(name: 'AppThemeSwitcher', template: '@app/shared/component/theme_switcher.html.twig')]
final class ThemeSwitcher
{
}
