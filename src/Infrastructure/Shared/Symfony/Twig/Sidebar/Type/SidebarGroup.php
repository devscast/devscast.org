<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Twig\Sidebar\Type;

/**
 * Class SidebarGroup.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class SidebarGroup implements SidebarItemInterface
{
    /**
     * @var SidebarLink[]
     */
    private array $links;

    private string $label;

    private string $icon;

    private bool $is_active = false;

    /**
     * SidebarGroup constructor.
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function __construct(string $label, string $icon, array $links = [])
    {
        $this->links = $links;
        $this->label = $label;
        $this->icon = $icon;
    }

    /**
     * @return SidebarLink[]
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param SidebarLink[] $links
     */
    public function setLinks(array $links): self
    {
        $this->links = $links;

        return $this;
    }

    public function getIcon(): string
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

    public function isIsActive(): bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }
}
