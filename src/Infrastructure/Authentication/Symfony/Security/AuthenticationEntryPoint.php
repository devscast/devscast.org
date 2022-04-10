<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\RememberMeToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

/**
 * Because the security component is a bit stupid and does not return an AccessDenied for users connected with a cookie
 * We redirect the treatment of this situation to the AccessDeniedHandler.
 *
 * Class AuthenticationEntryPoint
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    public function __construct(
        private readonly RouterInterface $router,
        private readonly AccessDeniedHandler $accessDeniedHandler
    ) {
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        $previous = $authException?->getPrevious();

        if (
            $authException instanceof InsufficientAuthenticationException &&
            $previous instanceof AccessDeniedException &&
            $authException->getToken() instanceof RememberMeToken
        ) {
            return $this->accessDeniedHandler->handle($request, $previous);
        }

        if (in_array('application/json', $request->getAcceptableContentTypes(), true)) {
            return new JsonResponse(
                data: [
                    'title' => "Vous n'avez pas les permissions suffisantes pour effectuer cette action",
                ],
                status: Response::HTTP_FORBIDDEN
            );
        }

        return new RedirectResponse($this->router->generate('authentication_login'));
    }
}
