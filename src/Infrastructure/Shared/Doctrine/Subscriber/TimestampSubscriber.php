<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Doctrine\Subscriber;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

/**
 * class TimestampSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TimestampSubscriber implements EventSubscriberInterface
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::postUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if (method_exists($object, 'setCreatedAt')) {
            $object->setCreatedAt(new \DateTimeImmutable());
        }
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if (method_exists($object, 'setUpdatedAt')) {
            $object->setUpdatedAt(new \DateTimeImmutable());
        }
    }
}
