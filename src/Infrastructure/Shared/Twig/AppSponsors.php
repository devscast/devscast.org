<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: '@app/shared/component/sponsors.html.twig')]
final class AppSponsors
{
}
