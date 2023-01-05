<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\EventSubscriber;

use Devscast\Tinify\Client;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Content;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Event\Events;

/**
 * class UploadEventSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UploadEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly Client $client,
        private readonly LoggerInterface $logger
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::POST_INJECT => 'onPostUpload',
        ];
    }

    public function onPostUpload(Event $event): void
    {
        /** @var Content|User $entity */
        $entity = $event->getObject();

        /** @var File|null $file */
        $file = $entity instanceof User ? $entity->getAvatarFile() : $entity->getThumbnailFile();

        if (
            in_array($file?->getExtension(), ['jpg', 'webp', 'png', 'jpeg'], true) &&
            true === boolval($_ENV['TINIFY_ENABLED'])
        ) {
            try {
                $filename = $file->getPathname();
                $this->client->toFile(
                    source: $this->client->fromFile($filename),
                    path: $filename
                );
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage(), $e->getTrace());
            }
        }
    }
}
