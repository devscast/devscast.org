<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller;

use Domain\Authentication\Entity\User;
use Infrastructure\Shared\Symfony\Messenger\DispatchTrait;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AbstractController.
 *
 * @method User|null getUser();
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractController extends SymfonyAbstractController
{
    use DispatchTrait;
    use FlashMessageTrait;

    public function __construct(
        protected readonly MessageBusInterface $commandBus,
        protected readonly TranslatorInterface $translator,
        protected readonly LoggerInterface $logger
    ) {
    }

    protected function redirectSeeOther(string $route, array $params = []): RedirectResponse
    {
        return $this->redirectToRoute($route, $params, Response::HTTP_SEE_OTHER);
    }

    protected function createUnprocessableEntityResponse(): Response
    {
        return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
