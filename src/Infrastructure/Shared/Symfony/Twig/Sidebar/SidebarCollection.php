<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Twig\Sidebar;

use ArrayIterator;
use Infrastructure\Shared\Symfony\Twig\Sidebar\Type\SidebarItemInterface;

/**
 * Collection of sidebar items
 * Class SidebarItemCollection.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class SidebarCollection implements \IteratorAggregate
{
    /**
     * @var SidebarItemInterface[]
     */
    private array $items = [];

    private array $options = [];

    private function __construct()
    {
    }

    public static function fromArray(array $items, array $options): self
    {
        return (new self())->setItems($items)
            ->setOptions($options);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }
}
