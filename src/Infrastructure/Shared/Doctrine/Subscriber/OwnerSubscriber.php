<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Doctrine\Subscriber;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

/**
 * class OwnerSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class OwnerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly Security $security
    ) {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if (
            method_exists($object, 'getOwner') &&
            method_exists($object, 'setOwner') &&
            null === $object->getOwner()
        ) {
            $object->setOwner($this->security->getUser());
        }
    }
}
