<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Api;

use Domain\Content\Entity\SubjectProposal;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class SubjectProposalVoteController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
final class SubjectProposalVoteController extends AbstractController
{
    #[Route('/api/content/subjects/vote/{id}', name: 'api_content_subject_proposal_vote', methods: ['POST'])]
    public function __invoke(SubjectProposal $proposal): void
    {
    }
}
