<?php

declare(strict_types=1);

namespace Application\Content\Handler\Blog;

use Application\Content\Command\Blog\CreatePostCommand;
use Application\Content\Service\ContentService;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Blog\Post;
use Domain\Content\Repository\Blog\PostRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreatePostHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreatePostHandler
{
    public function __construct(
        private readonly PostRepositoryInterface $repository,
        private readonly ContentService $contentService
    ) {
    }

    public function __invoke(CreatePostCommand $command): void
    {
        $this->contentService->assertPublishableContent($command);
        $this->repository->save(Mapper::getHydratedObject($command, new Post()));
    }
}
