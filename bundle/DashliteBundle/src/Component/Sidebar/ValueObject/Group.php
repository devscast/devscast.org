<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Sidebar\ValueObject;

use Webmozart\Assert\Assert;

/**
 * Class SidebarGroup.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Group
{
    public bool $active = false;

    private function __construct(
        public readonly string $label,
        public readonly string $icon,
        public array $links = []
    ) {
        $this->links = array_map(fn ($item) => Link::fromArray($item)->setParent($this), $this->links);
    }

    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'label');
        Assert::keyExists($data, 'icon');
        Assert::keyExists($data, 'links');

        return new self(
            $data['label'],
            $data['icon'],
            $data['links']
        );
    }
}
