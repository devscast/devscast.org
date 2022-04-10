<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Twig\Environment;

/**
 * Class AccessDeniedHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(
        private readonly Environment $twig
    ) {
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException): Response
    {
        $attributes = $accessDeniedException->getAttributes();

        if (in_array('application/json', $request->getAcceptableContentTypes(), true)) {
            return new JsonResponse(null, Response::HTTP_FORBIDDEN);
        }

        return new Response(
            content: $this->twig->render('bundles/TwigBundle/Exception/error403.html.twig'),
            status: Response::HTTP_FORBIDDEN
        );
    }
}
