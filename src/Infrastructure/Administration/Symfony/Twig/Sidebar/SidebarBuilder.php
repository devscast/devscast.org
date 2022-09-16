<?php

declare(strict_types=1);

namespace Infrastructure\Administration\Symfony\Twig\Sidebar;

use ArrayIterator;
use Infrastructure\Administration\Symfony\Twig\Sidebar\Type\SidebarItemInterface;

/**
 * Class SidebarBuilder.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class SidebarBuilder implements \IteratorAggregate, SidebarBuilderInterface
{
    private array $children = [];

    private string $translation_domain = 'messages';

    public function add(SidebarItemInterface $item): self
    {
        $this->children[$item->getLabel()] = $item;

        return $this;
    }

    public function get(string $name): array
    {
        if (! isset($this->children[$name])) {
            throw new \OutOfBoundsException(sprintf('The child with the name "%s" does not exist.', $name));
        }

        return $this->children[$name];
    }

    public function remove(string $name): self
    {
        if (! isset($this->children[$name])) {
            throw new \LogicException(sprintf('The child with the name "%s" does not exist.', $name));
        }

        unset($this->children[$name]);

        return $this;
    }

    public function create(): SidebarCollection
    {
        $items = [];
        foreach ($this->all() as $child) {
            $items[] = $child;
        }

        $options = [
            'translation_domain' => $this->translation_domain,
        ];

        return SidebarCollection::fromArray($items, $options);
    }

    public function has(string $name): bool
    {
        return isset($this->children[$name]);
    }

    public function all(): array
    {
        return $this->children;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->all());
    }

    public function count(): int
    {
        return \count($this->children);
    }

    public function setTranslationDomain(string $domain): SidebarBuilderInterface
    {
        $this->translation_domain = $domain;

        return $this;
    }
}
