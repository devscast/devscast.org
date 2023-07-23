<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class MobileNavigation.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(name: 'AppMobileNavigation', template: '@app/shared/component/mobile_navigation.html.twig')]
final class MobileNavigation
{
}
