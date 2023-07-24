<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Podcast;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class AppPromotedPodcastList.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(template: '@app/shared/component/podcast/promoted_list.html.twig')]
final class AppPromotedPodcastList
{
}
