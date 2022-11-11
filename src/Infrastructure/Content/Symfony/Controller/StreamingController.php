<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Domain\Content\ValueObject\ContentType;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class StreamingController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
final class StreamingController extends AbstractController
{
    #[Route('/streaming/{content_type}/{filename}', name: 'content_streaming', methods: ['GET'])]
    public function __invoke(string $content_type, string $filename): BinaryFileResponse
    {
        try {
            $path = match (true) {
                ContentType::podcast()->equals($content_type) => strval($this->getParameter('content.podcast_episode.upload_path')),
                ContentType::video()->equals($content_type) => strval($this->getParameter('content.video.upload_path')),
                default => throw new NotFoundHttpException(),
            };

            return new BinaryFileResponse("${path}/${filename}");
        } catch (FileNotFoundException | \Throwable) {
            throw new NotFoundHttpException();
        }
    }
}
