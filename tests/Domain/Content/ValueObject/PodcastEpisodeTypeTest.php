<?php

declare(strict_types=1);

namespace Tests\Domain\Content\ValueObject;

use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\PodcastEpisodeType;
use PHPUnit\Framework\TestCase;

/**
 * class ContentTypeTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class PodcastEpisodeTypeTest extends TestCase
{
    public function testInstanceValueCastToStringValue(): void
    {
        $values = ['Full', 'Trailer', 'Bonus'];

        foreach ($values as $name) {
            $this->assertSame($name, (string) PodcastEpisodeType::fromString($name));
        }
    }

    public function testInstanceValueHasExceptedOptions(): void
    {
        $this->assertSame(PodcastEpisodeType::VALUES, ['Full', 'Trailer', 'Bonus']);
    }

    public function testInstanceAndValueAreEquals(): void
    {
        $this->assertSame(true, ContentType::podcast()->equals('podcast'));
        $this->assertSame(true, ContentType::post()->equals('post'));
        $this->assertSame(true, ContentType::video()->equals('video'));
    }

    public function testSameInstanceValueAreEquals(): void
    {
        $a = ContentType::fromString('video');
        $b = ContentType::fromString('video');
        $this->assertSame(true, $a->equals($b));
        $this->assertSame(true, $b->equals($a));
    }

    public function testDifferentInstanceValueAreNotEquals(): void
    {
        $a = ContentType::fromString('podcast');
        $b = ContentType::fromString('video');
        $this->assertSame(false, $a->equals($b));
        $this->assertSame(false, $b->equals($a));
    }

    public function testStringValueEqualsInstanceValue(): void
    {
        $a = ContentType::fromString('post');
        $b = 'post';
        $this->assertSame(true, $a->equals($b));
    }
}
