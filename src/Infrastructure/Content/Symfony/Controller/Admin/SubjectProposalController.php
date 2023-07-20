<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreateSubjectProposalCommand;
use Application\Content\Command\DeleteSubjectProposalCommand;
use Application\Content\Command\UpdateSubjectProposalCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\SubjectProposal;
use Infrastructure\Content\Doctrine\Repository\SubjectProposalRepository;
use Infrastructure\Content\Symfony\Form\CreateSubjectProposalForm;
use Infrastructure\Content\Symfony\Form\UpdateSubjectProposalForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

/**
 * class SubjectProposalController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/proposals', 'admin_content_subject_proposal_')]
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
    public function new(#[CurrentUser] User $owner): Response
    {
        return $this->handleCommand(new CreateSubjectProposalCommand($owner), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreateSubjectProposalForm::class
        ));
    }

    #[Route('/{id}', name: 'show', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(SubjectProposal $item): Response
    {
        return $this->render(
            view: $this->getViewPath('show'),
            parameters: [
                'data' => $item,
            ]
        );
    }

    #[Route('/edit/{id}', name: 'edit', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET', 'POST'])]
    public function edit(SubjectProposal $item, #[CurrentUser] User $owner): Response
    {
        return $this->handleCommand(new UpdateSubjectProposalCommand($owner, $item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdateSubjectProposalForm::class,
            hasIndex: true,
            hasShow: false
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(SubjectProposal $item): Response
    {
        return $this->handleCommand(new DeleteSubjectProposalCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
