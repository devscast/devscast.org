<?php

declare(strict_types=1);

namespace Domain\Content\ValueObject;

/**
 * Class PodcastEpisodeAudio.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PodcastEpisodeAudio
{
    private function __construct(
        public readonly ?string $url = null,
        public readonly int $size = 0,
        public readonly ?string $type = null,
    ) {
    }

    public static function default(): self
    {
        return new self();
    }
}
