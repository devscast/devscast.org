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
        public ?string $url = null,
        public int $size = 0,
        public ?string $type = null,
    ) {
    }

    public static function default(): self
    {
        return new self();
    }
}
