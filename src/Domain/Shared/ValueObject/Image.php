<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObject;

/**
 * Class Image.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Image
{
    private function __construct(
        public readonly ?string $url = null,
        public readonly int $size = 0,
        public readonly ?string $type = null,
        public readonly array $dimensions = []
    ) {
    }

    public static function default(): self
    {
        return new self();
    }
}
