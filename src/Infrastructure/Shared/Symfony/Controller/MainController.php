<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller;

use Domain\Authentication\Entity\User;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Content\Repository\Blog\PostRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
final class MainController extends AbstractController
{
    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(PostRepositoryInterface $repository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render(
            view: null !== $user ? '@app/domain/home_logged.html.twig' : '@app/domain/home.html.twig' ,
            parameters: [
                'posts' => $repository->findBy([], limit: 5),
            ]
        );
    }

    #[Route('/offline', name: 'app_offline', methods: ['GET'])]
    public function offline(): Response
    {
        return $this->render('@app/domain/offline.html.twig');
    }
}
