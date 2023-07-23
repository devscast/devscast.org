<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class Header.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(name: 'AppHeader', template: '@app/shared/component/header.html.twig')]
final class Header
{
}
