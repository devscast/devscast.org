<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component\Sidebar\ValueObject;

use Webmozart\Assert\Assert;

/**
 * Class SidebarHeader.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Header
{
    public function __construct(
        public string $label
    ) {
    }

    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'label');

        return new self($data['label']);
    }
}
