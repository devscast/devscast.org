<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Podcast;

use Domain\Authentication\Entity\User;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class AppPodcastGuestCard.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(template: '@app/shared/component/podcast/guest_card.html.twig')]
final class AppPodcastGuestCard
{
    public User $guest;

    public function preMount(User $guest): void
    {
        $this->guest = $guest;
    }
}
