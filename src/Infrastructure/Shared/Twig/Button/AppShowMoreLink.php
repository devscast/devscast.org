<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Button;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class AppShowMoreLink.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(template: '@app/shared/component/button/show_more.html.twig')]
final class AppShowMoreLink
{
    public ?string $title = null;
    public string $path;
}
