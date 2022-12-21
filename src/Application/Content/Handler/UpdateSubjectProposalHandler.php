<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateSubjectProposalCommand;
use Application\Shared\Mapper;
use Domain\Content\Exception\CannotMutateAcceptedSubjectProposalException;
use Domain\Content\Repository\SubjectProposalRepositoryInterface;
use Domain\Content\ValueObject\SubjectProposalStatus;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateSubjectProposalHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateSubjectProposalHandler
{
    public function __construct(private readonly SubjectProposalRepositoryInterface $repository)
    {
    }

    public function __invoke(UpdateSubjectProposalCommand $command): void
    {
        if ($command->state->status->equals(SubjectProposalStatus::accepted())) {
            throw new CannotMutateAcceptedSubjectProposalException();
        }
        $this->repository->save(Mapper::getHydratedObject($command, $command->state));
    }
}
