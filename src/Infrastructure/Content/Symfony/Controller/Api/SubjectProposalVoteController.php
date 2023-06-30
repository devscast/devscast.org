<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Api;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Content\Entity\SubjectProposal;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class SubjectProposalVoteController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
final class SubjectProposalVoteController extends AbstractController
{
    #[Route('/api/content/subjects/vote/{id}', name: 'api_content_subject_proposal_vote', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST'])]
    public function __invoke(SubjectProposal $proposal): void
    {
    }
}
