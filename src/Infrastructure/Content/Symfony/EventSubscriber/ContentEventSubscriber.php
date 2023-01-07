<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\EventSubscriber;

use Application\Content\Command\IncreaseContentViewCommand;
use Domain\Content\Event\ContentViewedEvent;
use Domain\Content\Event\ContentViewMilestoneReachedEvent;
use Infrastructure\Shared\Symfony\Mailer\Mailer;
use Infrastructure\Shared\Symfony\Messenger\DispatchTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * class ContentEventSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContentEventSubscriber implements EventSubscriberInterface
{
    use DispatchTrait;

    public function __construct(
        protected readonly MessageBusInterface $commandBus,
        protected readonly LoggerInterface $logger,
        protected readonly Mailer $mailer
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ContentViewedEvent::class => 'onContentViewed',
            ContentViewMilestoneReachedEvent::class => 'onContentViewMilestoneReached',
        ];
    }

    public function onContentViewMilestoneReached(ContentViewMilestoneReachedEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/content/mail/content_view_milestone_reached.mail.twig',
            subject: 'content.mails.subjects.content_view_milestone_reached',
            subject_parameters: [
                '%views%' => $event->target->getUniqueViewCount(),
            ],
            domain: 'content'
        );
    }

    public function onContentViewed(ContentViewedEvent $event): void
    {
        try {
            $this->dispatchSync(new IncreaseContentViewCommand(
                target: $event->target,
                ip: $event->ip,
                owner: $event->owner
            ));
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
        }
    }
}
