<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdatePodcastEpisodeCommand;
use Application\Shared\Mapper;
use Domain\Content\Entity\PodcastEpisode;
use Infrastructure\Content\Doctrine\Repository\PodcastEpisodeRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdatePodcastEpisodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdatePodcastEpisodeHandler
{
    public function __construct(
        private readonly PodcastEpisodeRepository $repository
    ) {
    }

    public function __invoke(UpdatePodcastEpisodeCommand $command): void
    {
        /** @var PodcastEpisode $podcast */
        $podcast = Mapper::getHydratedObject($command, $command->state);
        $this->repository->save($podcast);
    }
}
