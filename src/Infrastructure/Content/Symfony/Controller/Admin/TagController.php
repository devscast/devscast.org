<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreateTagCommand;
use Application\Content\Command\DeleteTagCommand;
use Application\Content\Command\UpdateTagCommand;
use Domain\Content\Entity\Tag;
use Infrastructure\Content\Doctrine\Repository\TagRepository;
use Infrastructure\Content\Symfony\Form\CreateTagForm;
use Infrastructure\Content\Symfony\Form\UpdateTagForm;
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
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->executeFormCommand(new CreateTagCommand(), CreateTagForm::class);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Tag $row): Response
    {
        return $this->executeFormCommand(
            command: new UpdateTagCommand($row),
            formClass: UpdateTagForm::class,
            row: $row,
            view: 'edit'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(Tag $row): Response
    {
        return $this->executeDeleteCommand(new DeleteTagCommand($row), $row);
    }
}
