<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Infrastructure\Content\Doctrine\Repository\SubjectProposalRepository;
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
#[Route('/admin/content/subject/proposals', 'administration_content_subject_proposal_')]
final class SubjectProposalController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'subject_proposal';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(SubjectProposalRepository $repository): Response
    {
        return $this->render(
            view: $this->getViewPath('index'),
            parameters: [
                'data' => $this->paginator->paginate(
                    target: $repository->findBy([], orderBy: [
                        'created_at' => 'DESC',
                    ]),
                    page: $this->request->query->getInt('page', 1),
                    limit: 50
                ),
            ]
        );
    }
}
