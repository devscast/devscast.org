<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeleteSubjectProposalCommand;
use Domain\Content\Exception\CannotMutateAcceptedSubjectProposalException;
use Domain\Content\Repository\SubjectProposalRepositoryInterface;
use Domain\Content\ValueObject\SubjectProposalStatus;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DeleteSubjectProposalHandler
{
    public function __construct(
        private readonly SubjectProposalRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeleteSubjectProposalCommand $command): void
    {
        if (! $command->proposal->status->equals(SubjectProposalStatus::accepted())) {
            $this->repository->delete($command->proposal);
        } else {
            throw new CannotMutateAcceptedSubjectProposalException();
        }
    }
}
