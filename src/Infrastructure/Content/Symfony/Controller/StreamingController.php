<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route(
        '/streaming/{content_type<podcasts|videos>}/{filename<[a-zA-Z0-9-\.]+>}',
        name: 'content_streaming',
        methods: ['GET']
    )]
    public function __invoke(
        string $content_type,
        string $filename,
        Request $request
    ): BinaryFileResponse {
        try {
            $path = match ($content_type) {
                'podcasts' => strval($this->getParameter('content.podcast_episode.upload_path')),
                'videos' => strval($this->getParameter('content.video.upload_path')),
                default => throw new NotFoundHttpException(),
            };

            // todo handle progression on stream for stats
            /*if (null !== $this->getUser()) {
                $this->dispatchSync(new RegisterProgressionStream($filename));
            } else {
                $this->dispatchAsync(new RegisterPodcastStream($request->getClientIp(), $filename));
            }*/

            return new BinaryFileResponse("${path}/${filename}");
        } catch (FileNotFoundException | \Throwable) {
            throw new NotFoundHttpException();
        }
    }
}
