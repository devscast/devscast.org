<?php

declare(strict_types=1);

namespace Tests\Domain\Content\ValueObject;

use Domain\Content\ValueObject\SubjectProposalStatus;
use PHPUnit\Framework\TestCase;

/**
 * class SubjectProposalStatusTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class SubjectProposalStatusTest extends TestCase
{
    public function testInstanceValueCastToStringValue(): void
    {
        $valid = ['reviewing', 'accepted', 'rejected'];

        foreach ($valid as $name) {
            $this->assertSame($name, (string) SubjectProposalStatus::fromString($name));
        }
    }

    public function testInstanceValueHasExceptedOptions(): void
    {
        $this->assertSame(SubjectProposalStatus::VALUES, ['reviewing', 'accepted', 'rejected']);
    }

    public function testInstanceAndValueAreEquals(): void
    {
        $this->assertSame(true, SubjectProposalStatus::rejected()->equals('rejected'));
        $this->assertSame(true, SubjectProposalStatus::accepted()->equals('accepted'));
        $this->assertSame(true, SubjectProposalStatus::reviewing()->equals('reviewing'));
    }

    public function testSameInstanceValueAreEquals(): void
    {
        $a = SubjectProposalStatus::fromString('rejected');
        $b = SubjectProposalStatus::fromString('rejected');
        $this->assertSame(true, $a->equals($b));
        $this->assertSame(true, $b->equals($a));
    }

    public function testDifferentInstanceValueAreNotEquals(): void
    {
        $a = SubjectProposalStatus::fromString('rejected');
        $b = SubjectProposalStatus::fromString('accepted');
        $this->assertSame(false, $a->equals($b));
        $this->assertSame(false, $b->equals($a));
    }

    public function testStringValueEqualsInstanceValue(): void
    {
        $a = SubjectProposalStatus::fromString('rejected');
        $b = 'rejected';
        $this->assertSame(true, $a->equals($b));
    }
}
