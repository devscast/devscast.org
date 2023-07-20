<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreateTagCommand;
use Application\Content\Command\DeleteTagCommand;
use Application\Content\Command\UpdateTagCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\Tag;
use Infrastructure\Content\Doctrine\Repository\TagRepository;
use Infrastructure\Content\Symfony\Form\CreateTagForm;
use Infrastructure\Content\Symfony\Form\UpdateTagForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class TagController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/tags', 'admin_content_tag_')]
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
        return $this->handleCommand(new CreateTagCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreateTagForm::class,
            hasIndex: true
        ));
    }

    #[Route('/edit/{id}', name: 'edit', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET', 'POST'])]
    public function edit(Tag $item): Response
    {
        return $this->handleCommand(new UpdateTagCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdateTagForm::class,
            hasIndex: true,
            hasShow: false
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(Tag $item): Response
    {
        return $this->handleCommand(new DeleteTagCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
