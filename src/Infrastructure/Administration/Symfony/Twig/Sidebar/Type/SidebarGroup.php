<?php

declare(strict_types=1);

namespace Infrastructure\Administration\Symfony\Twig\Sidebar\Type;

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
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param SidebarLink[] $links
     *
     * @return $this
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function setLinks(array $links): self
    {
        $this->links = $links;

        return $this;
    }

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return SidebarGroup
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return SidebarGroup
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
