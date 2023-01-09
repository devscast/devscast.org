<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\EventSubscriber;

use Domain\Content\Entity\Content;
use Domain\Content\Entity\PodcastEpisode;
use Domain\Content\Entity\Post;
use Domain\Content\Entity\Training;
use Domain\Content\Entity\Video;
use Domain\Content\Repository\ContentRepositoryInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * class SitemapEventSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class SitemapEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly ContentRepositoryInterface $repository,
        private readonly UrlGeneratorInterface $generator
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SitemapPopulateEvent::class => 'populate',
        ];
    }

    public function populate(SitemapPopulateEvent $event): void
    {
        $this->registerContentUrls($event->getUrlContainer(), PodcastEpisode::class);
        $this->registerContentUrls($event->getUrlContainer(), Post::class);
        $this->registerContentUrls($event->getUrlContainer(), Video::class);
        $this->registerContentUrls($event->getUrlContainer(), Training::class);
    }

    private function registerContentUrls(UrlContainerInterface $urls, string $type): void
    {
        $section = match ($type) {
            Post::class => 'posts',
            Video::class => 'videos',
            Training::class => 'trainings',
            PodcastEpisode::class => 'podcasts',
            default => throw new \InvalidArgumentException(sprintf('unknown type %s', $type))
        };

        /** @var Content[] $contents */
        $contents = $this->repository->findContents($type);
        foreach ($contents as $content) {
            $urls->addUrl(
                url: new UrlConcrete(
                    loc: $this->generator->generate(
                        name: 'content_show',
                        parameters: [
                            'type' => $section,
                            'id' => $content->getId(),
                            'slug' => $content->getSlug(),
                        ],
                        referenceType: UrlGeneratorInterface::ABSOLUTE_URL
                    ),
                    lastmod: $content->getUpdatedAt(),
                    changefreq: 'daily',
                    priority: 0.8
                ),
                section: $section,
            );
        }
    }
}
