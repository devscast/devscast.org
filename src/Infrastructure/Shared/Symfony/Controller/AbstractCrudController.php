<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller;

use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * class AbstractCrudController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractCrudController extends AbstractController
{
    use DeleteCsrfTrait;

    protected const ROUTE_PREFIX = 'administration_';
    protected const DOMAIN = 'authentication';
    protected const ENTITY = 'user';

    protected readonly Request $request;

    public function __construct(
        protected readonly MessageBusInterface $commandBus,
        protected readonly TranslatorInterface $translator,
        protected readonly LoggerInterface $logger,
        protected readonly RequestStack $requestStack,
        protected readonly PaginatorInterface $paginator
    ) {
        if (null !== $this->requestStack->getCurrentRequest()) {
            $this->request = $this->requestStack->getCurrentRequest();
        }
    }

    public function getViewPath(string $name): string
    {
        return sprintf('@admin/domain/%s/%s/%s.html.twig', static::DOMAIN, static::ENTITY, $name);
    }

    public function getRouteName(string $name): string
    {
        return sprintf('%s%s_%s_%s', self::ROUTE_PREFIX, static::DOMAIN, static::ENTITY, $name);
    }
}
