<?php

declare(strict_types=1);

namespace Tests\Domain\Content\ValueObject;

use Domain\Content\ValueObject\ContentStatus;
use PHPUnit\Framework\TestCase;

/**
 * class ContentStatusTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContentStatusTest extends TestCase
{
    public function testInstanceValueCastToStringValue(): void
    {
        $values = ['draft', 'reviewing', 'published', 'rejected'];

        foreach ($values as $name) {
            $this->assertSame($name, (string) ContentStatus::fromString($name));
        }
    }

    public function testInstanceValueHasExceptedOptions(): void
    {
        $this->assertSame(ContentStatus::VALUES, ['draft', 'reviewing', 'published', 'rejected']);
    }

    public function testInstanceAndValueAreEquals(): void
    {
        $this->assertSame(true, ContentStatus::draft()->equals('draft'));
        $this->assertSame(true, ContentStatus::reviewing()->equals('reviewing'));
        $this->assertSame(true, ContentStatus::published()->equals('published'));
        $this->assertSame(true, ContentStatus::rejected()->equals('rejected'));
    }

    public function testSameInstanceValueAreEquals(): void
    {
        $a = ContentStatus::fromString('draft');
        $b = ContentStatus::fromString('draft');
        $this->assertSame(true, $a->equals($b));
        $this->assertSame(true, $b->equals($a));
    }

    public function testDifferentInstanceValueAreNotEquals(): void
    {
        $a = ContentStatus::fromString('draft');
        $b = ContentStatus::fromString('rejected');
        $this->assertSame(false, $a->equals($b));
        $this->assertSame(false, $b->equals($a));
    }

    public function testStringValueEqualsInstanceValue(): void
    {
        $a = ContentStatus::fromString('published');
        $b = 'published';
        $this->assertSame(true, $a->equals($b));
    }
}
