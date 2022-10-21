<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreateVideoCommand;
use Application\Content\Command\DeleteVideoCommand;
use Application\Content\Command\UpdateVideoCommand;
use Domain\Content\Entity\Video;
use Infrastructure\Content\Doctrine\Repository\VideoRepository;
use Infrastructure\Content\Symfony\Form\CreateVideoForm;
use Infrastructure\Content\Symfony\Form\UpdateVideoForm;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class VideoController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/videos', 'administration_content_video_')]
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
        $owner = $this->getUser();

        return $this->executeFormCommand(new CreateVideoCommand($owner), CreateVideoForm::class);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Video $row): Response
    {
        return $this->executeFormCommand(
            command: new UpdateVideoCommand($row),
            formClass: UpdateVideoForm::class,
            row: $row,
            view: 'edit'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(Video $row): Response
    {
        return $this->executeDeleteCommand(new DeleteVideoCommand($row), $row);
    }
}
