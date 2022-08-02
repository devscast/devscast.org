<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\ToggleSubjectProposalVoteCommand;
use Domain\Content\Entity\SubjectProposalVote;
use Domain\Content\Repository\SubjectProposalRepositoryInterface;
use Domain\Content\Repository\SubjectProposalVoteRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ToggleSubjectProposalVoteHandler
{
    public function __construct(
        private readonly SubjectProposalVoteRepositoryInterface $voteRepository,
        private readonly SubjectProposalRepositoryInterface $proposalRepository
    ) {
    }

    public function __invoke(ToggleSubjectProposalVoteCommand $command): void
    {
        $vote = $this->voteRepository->findVote($command->voter, $command->proposal);
        if (null === $vote) {
            $this->voteRepository->save(SubjectProposalVote::create($command->voter, $command->proposal));
            $command->proposal->increaseVotesCount();
        } else {
            $command->proposal->decreaseVotesCount();
            $this->voteRepository->delete($vote);
        }

        $this->proposalRepository->save($command->proposal);
    }
}
