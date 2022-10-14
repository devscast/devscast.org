<?php

declare(strict_types=1);

namespace Domain\Content\ValueObject;

use Webmozart\Assert\Assert;

/**
 * Class PodcastEpisodeType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PodcastEpisodeType implements \Stringable
{
    final public const VALUES = ['Full', 'Trailer', 'Bonus'];
    final public const CHOICES = [
        'content.value_object.podcast_episode_type.full' => 'Full',
        'content.value_object.podcast_episode_type.trailer' => 'Trailer',
        'content.value_object.podcast_episode_type.bonus' => 'Bonus'
    ];
    private string $episode_type = 'Full';

    private function __construct(string $type)
    {
        Assert::inArray($type, self::VALUES);
        $this->episode_type = $type;
    }

    public function __toString(): string
    {
        return $this->episode_type;
    }

    public function getTranslationKey(): string
    {
        return strval(array_search($this->episode_type, self::CHOICES));
    }

    public static function full(): self
    {
        return new self('Full');
    }

    public static function trailer(): self
    {
        return new self('Trailer');
    }

    public static function bonus(): self
    {
        return new self('Bonus');
    }

    public static function fromString(string $type): self
    {
        return new self($type);
    }

    public function equals(self|string $type): bool
    {
        if ($type instanceof self) {
            return $type->episode_type === $this->episode_type;
        }

        return $this->episode_type === $type;
    }
}
