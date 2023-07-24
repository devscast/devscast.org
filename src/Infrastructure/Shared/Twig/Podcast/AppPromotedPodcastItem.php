<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Podcast;

use Domain\Content\Entity\PodcastEpisode;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class AppPromotedPodcast.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(template: '@app/shared/component/podcast/promoted_item.html.twig')]
final class AppPromotedPodcastItem
{
}
