<?php

declare(strict_types=1);

namespace Domain\Content\ValueObject;

/**
 * Class Image.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Image
{
    private function __construct(
        public ?string $url = null,
        public int $size = 0,
        public ?string $type = null,
        public array $dimensions = []
    ) {
    }

    public static function default(): self
    {
        return new self();
    }
}
