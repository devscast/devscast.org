<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class Sidebar.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(name: 'AppSidebar', template: '@app/shared/component/sidebar.html.twig')]
final class Sidebar
{
}
