<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Sidebar\ValueObject;

use Webmozart\Assert\Assert;

/**
 * Class SidebarItem.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Link
{
    public ?Group $parent = null;

    public function __construct(
        public string $url,
        public string $label,
        public ?string $icon = null,
        public ?string $badge = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'url');
        Assert::keyExists($data, 'label');
        Assert::keyExists($data, 'icon');

        return new self(
            $data['url'],
            $data['label'],
            $data['icon'] ?? null,
            $data['badge'] ?? null,
        );
    }

    public function setParent(Group $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
