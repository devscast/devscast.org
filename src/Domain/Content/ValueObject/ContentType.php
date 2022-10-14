<?php

declare(strict_types=1);

namespace Domain\Content\ValueObject;

use Webmozart\Assert\Assert;

/**
 * class ContentType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class ContentType
{
    final public const VALUES = ['podcast', 'post', 'video'];
    final public const CHOICES = [
        'content.value_object.content_type.post' => 'post',
        'content.value_object.content_type.podcast' => 'podcast',
        'content.value_object.content_type.video' => 'video',
    ];
    private string $content_type = 'post';

    private function __construct(string $type)
    {
        Assert::inArray($type, self::VALUES);
        $this->content_type = $type;
    }

    public function __toString(): string
    {
        return $this->content_type;
    }

    public function getTranslationKey(): string
    {
        return strval(array_search($this->content_type, self::CHOICES, true));
    }

    public static function podcast(): self
    {
        return new self('podcast');
    }

    public static function video(): self
    {
        return new self('video');
    }

    public static function post(): self
    {
        return new self('post');
    }

    public static function fromString(string $type): self
    {
        return new self($type);
    }

    public function equals(self|string $type): bool
    {
        if ($type instanceof self) {
            return $type->content_type === $this->content_type;
        }

        return $this->content_type === $type;
    }
}
