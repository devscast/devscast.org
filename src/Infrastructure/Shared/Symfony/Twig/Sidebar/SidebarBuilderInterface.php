<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Twig\Sidebar;

use Infrastructure\Shared\Symfony\Twig\Sidebar\Type\SidebarItemInterface;

/**
 * Interface SidebarBuilderInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface SidebarBuilderInterface extends \Traversable, \Countable
{
    public function add(SidebarItemInterface $item): self;

    public function addLink(string $route, string $label, ?string $icon = null, ?string $badge = null, array $params = []): self;

    public function addGroup(string $label, string $icon, array $links = []): self;

    public function addHeader(string $label): self;

    public function get(string $name): array;

    public function remove(string $name): self;

    public function has(string $name): bool;

    public function all(): array;

    public function create(): SidebarCollection;

    public function setTranslationDomain(string $domain): self;
}
