<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreateSubjectProposalCommand;
use Application\Content\Command\DeleteSubjectProposalCommand;
use Application\Content\Command\UpdateSubjectProposalCommand;
use Domain\Content\Entity\SubjectProposal;
use Infrastructure\Content\Doctrine\Repository\SubjectProposalRepository;
use Infrastructure\Content\Symfony\Form\CreateSubjectProposalForm;
use Infrastructure\Content\Symfony\Form\UpdateSubjectProposalForm;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class SubjectProposalController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/subject_proposals', 'administration_content_subject_proposal_')]
final class SubjectProposalController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'subject_proposal';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(SubjectProposalRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        $owner = $this->getUser();

        return $this->executeFormCommand(new CreateSubjectProposalCommand($owner), CreateSubjectProposalForm::class);
    }

    #[Route('/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(SubjectProposal $row): Response
    {
        return $this->executeFormCommand(
            command: new UpdateSubjectProposalCommand($this->getUser(), state: $row),
            formClass: UpdateSubjectProposalForm::class
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(SubjectProposal $row): Response
    {
        return $this->executeDeleteCommand(new DeleteSubjectProposalCommand($row), $row);
    }
}
