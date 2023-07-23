<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Podcast;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class PromotedPodcastList.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(name: 'AppPromotedPodcastList', template: '@app/shared/component/podcast/promoted_list.html.twig')]
final class PromotedPodcastList
{
}
