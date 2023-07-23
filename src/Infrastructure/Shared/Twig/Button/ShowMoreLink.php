<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Button;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class ShowMoreLink.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(name: 'AppShowMoreLink', template: '@app/shared/component/button/show_more.html.twig')]
final class ShowMoreLink
{
    public ?string $title = null;
    public string $path;
}
