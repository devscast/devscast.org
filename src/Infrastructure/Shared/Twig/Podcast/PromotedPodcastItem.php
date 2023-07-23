<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Podcast;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class PromotedPodcast.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(name: 'AppPromotedPodcastItem', template: '@app/shared/component/podcast/promoted_item.html.twig')]
final class PromotedPodcastItem
{
}
