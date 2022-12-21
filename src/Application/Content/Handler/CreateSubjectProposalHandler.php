<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateSubjectProposalCommand;
use Domain\Content\Entity\SubjectProposal;
use Domain\Content\Exception\SubjectProposalLimitReachedException;
use Domain\Content\Repository\SubjectProposalRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateSubjectProposalHandler
{
    public const LIMIT_PER_MONTH = 2;

    public function __construct(
        private readonly SubjectProposalRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateSubjectProposalCommand $command): void
    {
        if (
            $command->owner->getCreatedAt() < new \DateTime('-1 month') &&
            $this->repository->countRecentFor($command->owner) < self::LIMIT_PER_MONTH ||
            $command->owner->isAdmin()
        ) {
            $this->repository->save(SubjectProposal::create($command->owner, (string) $command->subject));
        } else {
            throw new SubjectProposalLimitReachedException();
        }
    }
}
