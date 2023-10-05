<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Podcast;

use Domain\Content\Entity\Podcast\Episode;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class AppPodcastCard.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(template: '@app/shared/component/podcast/card.html.twig')]
final class AppPodcastCard
{
    public Episode $episode;

    public function mount(Episode $episode): void
    {
        $this->episode = $episode;
    }
}
