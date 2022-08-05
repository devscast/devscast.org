<?php

declare(strict_types=1);

namespace Tests\Domain\Content\ValueObject;

use Domain\Content\ValueObject\EducationLevel;
use PHPUnit\Framework\TestCase;

/**
 * class EducationLevelTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class EducationLevelTest extends TestCase
{
    public function testInstanceValueCastToStringValue(): void
    {
        $values = ['beginner', 'intermediate', 'advanced'];

        foreach ($values as $name) {
            $this->assertSame($name, (string) EducationLevel::fromString($name));
        }
    }

    public function testInstanceValueHasExceptedOptions(): void
    {
        $this->assertSame(EducationLevel::VALUES, ['beginner', 'intermediate', 'advanced']);
    }

    public function testInstanceAndValueAreEquals(): void
    {
        $this->assertSame(true, EducationLevel::beginner()->equals('beginner'));
        $this->assertSame(true, EducationLevel::intermediate()->equals('intermediate'));
        $this->assertSame(true, EducationLevel::advanced()->equals('advanced'));
    }

    public function testSameInstanceValueAreEquals(): void
    {
        $a = EducationLevel::fromString('beginner');
        $b = EducationLevel::fromString('beginner');
        $this->assertSame(true, $a->equals($b));
        $this->assertSame(true, $b->equals($a));
    }

    public function testDifferentInstanceValueAreNotEquals(): void
    {
        $a = EducationLevel::fromString('beginner');
        $b = EducationLevel::fromString('advanced');
        $this->assertSame(false, $a->equals($b));
        $this->assertSame(false, $b->equals($a));
    }

    public function testStringValueEqualsInstanceValue(): void
    {
        $a = EducationLevel::fromString('advanced');
        $b = 'advanced';
        $this->assertSame(true, $a->equals($b));
    }
}
