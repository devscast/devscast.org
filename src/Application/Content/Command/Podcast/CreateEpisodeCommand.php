<?php

declare(strict_types=1);

namespace Application\Content\Command\Podcast;

use Application\Content\Command\AbstractContentCommand;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Content\Entity\Podcast\Season;
use Domain\Content\Enum\ContentType;
use Domain\Content\Enum\EpisodeType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreatePodcastEpisodeCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateEpisodeCommand extends AbstractContentCommand
{
    public function __construct(
        public ?Season $season = null,
        public ?File $audio_file = null,
        #[Assert\GreaterThanOrEqual(1)] public ?int $episode_number = null,
        public EpisodeType $episode_type = EpisodeType::FULL,
        public ContentType $content_type = ContentType::PODCAST,
        public Collection $guests = new ArrayCollection()
    ) {
    }
}
