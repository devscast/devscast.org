<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\EventSubscriber;

use Domain\Content\Entity\Content;
use Domain\Content\Enum\ContentType;
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
final readonly class SitemapEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ContentRepositoryInterface $repository,
        private UrlGeneratorInterface $generator
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
        $this->registerContentUrls($event->getUrlContainer(), ContentType::PODCAST);
        $this->registerContentUrls($event->getUrlContainer(), ContentType::POST);
        $this->registerContentUrls($event->getUrlContainer(), ContentType::VIDEO);
    }

    private function registerContentUrls(UrlContainerInterface $urls, ContentType $type): void
    {
        /** @var Content[] $contents */
        $contents = $this->repository->findAll();

        foreach ($contents as $content) {
            $urls->addUrl(
                url: new UrlConcrete(
                    loc: $this->generator->generate(
                        name: $type->getRoute(),
                        parameters: [
                            'id' => $content->getId()?->toHex(),
                            'slug' => $content->getSlug(),
                        ],
                        referenceType: UrlGeneratorInterface::ABSOLUTE_URL
                    ),
                    lastmod: $content->getUpdatedAt(),
                    changefreq: 'daily',
                    priority: 0.8
                ),
                section: $type->value,
            );
        }
    }
}
