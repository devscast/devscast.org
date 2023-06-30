<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\IncreaseContentViewCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\ContentView;
use Domain\Content\Event\ContentViewMilestoneReachedEvent;
use Domain\Content\Repository\ContentRepositoryInterface;
use Domain\Content\Repository\ContentViewRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class IncreaseContentViewHandler
{
    public function __construct(
        private readonly ContentViewRepositoryInterface $repository,
        private readonly ContentRepositoryInterface $contentRepository,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(IncreaseContentViewCommand $command): void
    {
        $command->target->increaseViewCount();
        $viewed = $this->repository->isContentAlreadyViewed($command->target, $command->ip, $command->owner);

        if (false === $viewed) {
            $this->repository->save(Mapper::getHydratedObject($command, new ContentView()));
            $command->target->increaseUniqueViewCount();
        }

        if ($command->target->hasReachedViewMilestone() && null !== $command->target->getOwner()) {
            $this->dispatcher->dispatch(
                new ContentViewMilestoneReachedEvent($command->target, $command->target->getOwner())
            );
        }

        $this->contentRepository->save($command->target);
    }
}
