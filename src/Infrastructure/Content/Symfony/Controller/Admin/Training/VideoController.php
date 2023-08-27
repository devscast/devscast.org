<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin\Training;

use Application\Content\Command\Training\CreateVideoCommand;
use Application\Content\Command\Training\DeleteVideoCommand;
use Application\Content\Command\Training\UpdateVideoCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\Training\Video;
use Infrastructure\Content\Doctrine\Repository\Training\VideoRepository;
use Infrastructure\Content\Symfony\Form\Training\CreateVideoForm;
use Infrastructure\Content\Symfony\Form\Training\UpdateVideoForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class VideoController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/videos', 'admin_content_video_')]
final class VideoController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'video';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(VideoRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->handleCommand(new CreateVideoCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreateVideoForm::class,
            hasIndex: true,
            hasShow: true
        ));
    }

    #[Route('/{id}', name: 'show', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(Video $item): Response
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
    public function edit(Video $item): Response
    {
        return $this->handleCommand(new UpdateVideoCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdateVideoForm::class,
            hasIndex: true,
            hasShow: true
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(Video $item): Response
    {
        return $this->handleCommand(new DeleteVideoCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
