<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Sidebar;

use Devscast\Bundle\DashliteBundle\Component\Sidebar\ValueObject\Group;
use Devscast\Bundle\DashliteBundle\Component\Sidebar\ValueObject\Header;
use Devscast\Bundle\DashliteBundle\Component\Sidebar\ValueObject\Link;
use Devscast\Bundle\DashliteBundle\Component\Sidebar\ValueObject\Sidebar as SidebarValueObject;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

/**
 * Class Sidebar.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class DashliteSidebar
{
    public array $data = [];
    public ?string $html = null;
    private string $path;
    private string $route;

    public function __construct(
        readonly RequestStack $stack,
    ) {
        $this->path = strval($stack->getCurrentRequest()?->getPathInfo());
        $this->route = strval($stack->getCurrentRequest()?->attributes?->getString('_route'));
    }

    #[PreMount]
    public function preMount(array $data): void
    {
        $collection = new SidebarValueObject($data);
        $html = '';
        foreach ($collection as $item) {
            if ($item instanceof Link) {
                $html .= $this->renderLink($item);
            }

            if ($item instanceof Header) {
                $html .= $this->renderHeader($item);
            }

            if ($item instanceof Group) {
                $html .= $this->renderGroup($item);
            }
        }

        $this->html = $html;
    }

    public function activeClass(string $path, string $active = 'active', string $inactive = '', bool $relative = false): string
    {
        $isCurrentPathMatches = $this->path === $path || $this->route === $path;
        $isCurrentPathContains = str_contains($this->path, $path) || str_contains($this->route, $path);

        return  (true === $relative && $isCurrentPathContains) || $isCurrentPathMatches ? $active : $inactive;
    }


    private function renderLinks(array $items, ?Group $parent = null): string
    {
        $html = '';
        foreach ($items as $item) {
            $item->setParent($parent);
            $html .= $this->renderLink($item);
        }

        return $html;
    }

    private function renderLink(Link $item): string
    {
        $activeClass = $this->activeClass($item->url, active: 'active current-page', relative: true);
        $currentClass = $this->activeClass($item->url, active: 'aria-current="page"');
        $icon = !empty($item->icon) ? "<span class='nk-menu-icon'><em class='icon ni ni-{$item->icon}'></em></span>" : '';
        $badge = !empty($item->badge) ? "<span class='nk-menu-badge bg-primary'>{$item->badge}</span>" : '';

        $active = 'active current-page' === $activeClass;
        if ($active && null !== $item->parent) {
            $item->parent->active = true;
        }

        return <<< HTML
            <li class="nk-menu-item {$activeClass}">
                <a {$currentClass} aria-label="{$item->label}" title="{$item->label}" href="{$item->url}" class="nk-menu-link">
                    {$icon}
                    <span class="nk-menu-text">{$item->label}</span>
                    {$badge}
                </a>
            </li>
        HTML;
    }

    private function renderHeader(Header $item): string
    {
        return <<< HTML
            <li class="nk-menu-heading">
                <h6 class="overline-title text-primary-alt" aria-label="{$item->label}">
                    {$item->label}
                </h6>
            </li>
        HTML;
    }

    private function renderGroup(Group $item): string
    {
        $links = $this->renderLinks($item->links, $item);
        $groupActiveClass = $item->active ? 'active' : '';

        return <<< HTML
            <li class="nk-menu-item has-sub {$groupActiveClass}">
                <a href="#" class="nk-menu-link nk-menu-toggle" aria-label="{$item->label}">
                    <span class="nk-menu-icon"><em class="icon ni ni-{$item->icon}"></em></span>
                    <span class="nk-menu-text">{$item->label}</span>
                </a>
                <ul class="nk-menu-sub">
                    {$links}
                </ul>
            </li>
        HTML;
    }
}
