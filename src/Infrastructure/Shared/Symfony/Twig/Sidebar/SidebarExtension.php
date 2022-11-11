<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Twig\Sidebar;

use Infrastructure\Shared\Symfony\Twig\Sidebar\Type\SidebarGroup;
use Infrastructure\Shared\Symfony\Twig\Sidebar\Type\SidebarHeader;
use Infrastructure\Shared\Symfony\Twig\Sidebar\Type\SidebarLink;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class SidebarExtension.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class SidebarExtension extends AbstractExtension
{
    private string $route;

    private string $path;

    private string $defaultSidebarClass;

    public function __construct(
        readonly RequestStack $stack,
        private readonly SidebarBuilderInterface $builder,
        private readonly TranslatorInterface $translator,
        private readonly RouterInterface $router,
        private readonly ContainerInterface $container
    ) {
        $this->path = strval($stack->getCurrentRequest()?->getPathInfo());
        $this->route = strval($stack->getCurrentRequest()?->attributes?->get('_route'));
        $this->defaultSidebarClass = strval($this->container->getParameter('devscast.administration.default_sidebar'));
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('sidebar_render', [$this, 'renderSidebar'], [
                'is_safe' => ['html'],
            ]),
            new TwigFunction('active_class', [$this, 'activeClass']),
            new TwigFunction('active_route', [$this, 'activeRoute']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('sidebar', [$this, 'renderSidebar'], [
                'is_safe' => ['html'],
            ]),
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

    public function renderSidebar(?string $sidebarClass = null): string
    {
        $sidebar = $this->container->get(null === $sidebarClass ? $this->defaultSidebarClass : $sidebarClass);

        if ($sidebar instanceof AbstractSidebar) {
            $collection = $sidebar->build($this->builder);
            $translation_domain = $collection->getOptions()['translation_domain'];

            $s = '';
            foreach ($collection as $item) {
                if ($item instanceof SidebarLink) {
                    $s = $this->renderItem($s, $item, $translation_domain);
                }

                if ($item instanceof SidebarHeader) {
                    $s .= <<< HTML
                        <li class="nk-menu-heading">
                            <h6 
                                class="overline-title text-primary-alt" 
                                aria-label="{$this->translator->trans($item->getLabel(), domain: $translation_domain)}"
                            >
                                {$this->translator->trans($item->getLabel(), domain: $translation_domain)}
                            </h6>
                        </li>
                    HTML;
                }

                if ($item instanceof SidebarGroup) {
                    $links = $this->renderItems($item->getLinks(), $translation_domain, $item);
                    $groupActiveClass = $item->isIsActive() ? 'active' : '';
                    $s .= <<< HTML
                        <li class="nk-menu-item has-sub {$groupActiveClass}">
                            <a 
                                href="#" 
                                class="nk-menu-link nk-menu-toggle" 
                                aria-label="{$this->translator->trans($item->getLabel(), domain: $translation_domain)}"
                            >
                                <span class="nk-menu-icon"><em class="icon ni ni-{$item->getIcon()}"></em></span>
                                <span class="nk-menu-text">{$this->translator->trans($item->getLabel(), domain: $translation_domain)}</span>
                            </a>
                            <ul class="nk-menu-sub">
                                {$links}
                            </ul>
                        </li>
                    HTML;
                }
            }

            return $s;
        }

        throw new \RuntimeException(sprintf('The sidebar must be an instance of %s', AbstractSidebar::class));
    }

    /**
     * @param SidebarLink[] $items
     */
    private function renderItems(array $items, string $translation_domain = 'messages', ?SidebarGroup $parent = null): string
    {
        $html = '';
        foreach ($items as $item) {
            $item->setParent($parent);
            $html = $this->renderItem($html, $item, $translation_domain);
        }

        return $html;
    }

    private function renderItem(string $html, SidebarLink $item, string $translation_domain = 'messages'): string
    {
        $label = $this->translator->trans($item->getLabel(), domain: $translation_domain);
        $badge = $this->translator->trans($item->getBadge(), domain: $translation_domain);
        $url = $this->router->generate($item->getRoute(), $item->getParams());
        $activeClass = $this->activeClass($url, activeClass: 'active current-page', relative: true);
        $currentClass = $this->activeClass($item->getRoute(), activeClass: 'aria-current="page"');
        $icon = ! empty($item->getIcon()) ?
            "<span class='nk-menu-icon'><em class='icon ni ni-{$item->getIcon()}'></em></span>" : '';

        $active = 'active current-page' === $activeClass;
        if ($active && null !== $item->getParent()) {
            $item->getParent()->setIsActive(true);
        }

        $html .= <<< HTML
            <li class="nk-menu-item ${activeClass}">
                <a ${currentClass} aria-label="${label}" title="${label}" href="${url}" class="nk-menu-link">
                    ${icon}
                    <span class="nk-menu-text">${label}</span>
                    <span class="nk-menu-badge bg-primary">${badge}</span>
                </a>
            </li>
        HTML;

        return $html;
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
