<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Messenger\CommandBusAwareDispatchTrait;
use Knp\Component\Pager\PaginatorInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AbstractController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractController extends SymfonyAbstractController
{
    use FlashMessageTrait;
    use CommandBusAwareDispatchTrait;

    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'translator' => '?' . TranslatorInterface::class,
            'knp_paginator' => '?' . PaginatorInterface::class,
            'logger' => '?' . LoggerInterface::class,
            'event_dispatcher' => '?' . EventDispatcherInterface::class,
            'messenger.default_bus' => '?' . MessageBusInterface::class,
        ]);
    }

    public function getLogger(): LoggerInterface
    {
        return $this->container->get('logger');
    }

    public function getCommandBus(): MessageBusInterface
    {
        return $this->container->get('messenger.default_bus');
    }

    protected function redirectSeeOther(string $route, array $params = []): RedirectResponse
    {
        return $this->redirectToRoute($route, $params, Response::HTTP_SEE_OTHER);
    }

    protected function createUnprocessableEntityResponse(): Response
    {
        return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function dispatchEvent(object $event): object
    {
        return $this->container->get('event_dispatcher')->dispatch($event);
    }

    protected function getCurrentRequest(): Request
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();

        if (null === $request) {
            throw new \RuntimeException("unable to get the current request");
        }

        return $request;
    }

    protected function getTranslator(): TranslatorInterface
    {
        return $this->container->get('translator');
    }

    protected function getPaginator(): PaginatorInterface
    {
        return $this->container->get('knp_paginator');
    }
}
