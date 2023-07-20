<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Extension;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class TwigLinkExtension.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class TwigLinkExtension extends AbstractExtension
{
    private string $route;
    private string $path;

    public function __construct(RequestStack $stack, private readonly RouterInterface $router)
    {
        $this->path = $stack->getCurrentRequest()?->getPathInfo() ?? '';
        $this->route = $stack->getCurrentRequest()?->attributes?->get('_route') ?? '';
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('active_class', [$this, 'activeClass']),
            new TwigFunction('active_route', [$this, 'activeRoute'])
        ];
    }

    public function activeClass(
        string|array $path,
        string $activeClass = 'active',
        string $inactiveClass = '',
        bool $relative = false
    ): string {
        if (is_array($path)) {
            [$route, $params] = $path;
            if ($this->router->generate($route, $params) === $this->path) {
                return $activeClass;
            }
        } elseif (is_string($path)) {
            if (
                (true === $relative && $this->isCurrentPathContains($path)) ||
                $this->isCurrentPathMatches($path)
            ) {
                return $activeClass;
            }
        }

        return $inactiveClass;
    }

    public function activeRoute(string $path, bool $relative = false): bool
    {
        if ($relative) {
            return str_contains($this->route, $path);
        }
        return $this->route === $path;
    }

    private function isCurrentPathMatches(string $path): bool
    {
        return $this->path === $path || $this->route === $path;
    }

    private function isCurrentPathContains(string $path): bool
    {
        return str_contains($this->path, $path) || str_contains($this->route, $path);
    }
}
