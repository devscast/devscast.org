<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Twig\Sidebar\Type;

/**
 * Class SidebarItem.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class SidebarLink implements SidebarItemInterface
{
    private string $icon;

    private string $badge;

    private ?SidebarGroup $parent = null;

    public function __construct(
        private string $route,
        private string $label,
        ?string $icon = null,
        ?string $badge = null,
        private array $params = []
    ) {
        $this->icon = null === $icon ? '' : $icon;
        $this->badge = null === $badge ? '' : $badge;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getBadge(): string
    {
        return $this->badge;
    }

    public function setBadge(string $badge): self
    {
        $this->badge = $badge;

        return $this;
    }

    public function getParent(): ?SidebarGroup
    {
        return $this->parent;
    }

    public function setParent(?SidebarGroup $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
