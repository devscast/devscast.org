<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Infrastructure\Content\Doctrine\Repository\TagRepository;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class TagController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/tags', 'administration_content_tag_')]
final class TagController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'tag';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(TagRepository $repository): Response
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
