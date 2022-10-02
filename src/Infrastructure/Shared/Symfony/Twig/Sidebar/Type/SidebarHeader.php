<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Twig\Sidebar\Type;

/**
 * Class SidebarHeader.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class SidebarHeader implements SidebarItemInterface
{
    private string $label;

    /**
     * SidebarHeader constructor.
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function __construct(string $label)
    {
        $this->label = $label;
    }

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return SidebarHeader
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
