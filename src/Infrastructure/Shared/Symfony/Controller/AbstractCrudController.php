<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AbstractCrudController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractCrudController extends AbstractController
{
    public function __construct(
        protected readonly EntityManagerInterface $em,
        protected readonly EventDispatcherInterface $dispatcher,
        protected readonly RequestStack $requestStack,
        protected readonly MessageBusInterface $commandBus,
        protected readonly TranslatorInterface $translator,
        protected readonly LoggerInterface $logger
    ) {
        parent::__construct($this->commandBus, $this->translator, $this->logger);
    }
}
