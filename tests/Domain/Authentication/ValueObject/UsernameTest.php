<?php

declare(strict_types=1);

namespace Tests\Domain\Authentication\ValueObject;

use Domain\Authentication\ValueObject\Username;
use PHPUnit\Framework\TestCase;

/**
 * Class UsernameTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UsernameTest extends TestCase
{
    public function testInstanceValueCastToStringValue(): void
    {
        $a = Username::fromString('username');
        $this->assertSame('username', (string) $a);
    }

    public function testCreateUsernameWithShortLength(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('authentication.validations.short_username');
        Username::fromString('four');
    }

    public function testCreateLongUsername(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('authentication.validations.long_username');
        Username::fromString('iiidkdkdkdkdkdkdkdkdkdkdkdkdkdkdkdkdkdkdkk');
    }

    public function testCreateEmptyUsername(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('authentication.validations.empty_username');
        Username::fromString('');
    }

    public function testUsernameValidFormat(): void
    {
        $validNames = [
            'bernard',
            'bernard.ng',
            '_bernard.ng_',
            'NGBernard',
            '44bernard',
            '_90___a',
            'BERNARD',
        ];

        foreach ($validNames as $name) {
            $this->assertSame($name, (string) Username::fromString($name));
        }
    }

    public function testUsernameInvalidFormat(): void
    {
        $exceptions = [];
        $invalidNames = [
            'hello world',
            'hello-world',
            '.helloworld',
            'helloworld.',
            '44555',
            '@hd999',
        ];

        foreach ($invalidNames as $name) {
            try {
                Username::fromString($name);
            } catch (\InvalidArgumentException) {
                $exceptions[] = $name;
            }
        }

        $this->assertSame($invalidNames, $exceptions);
    }

    public function testSameInstanceValueAreEquals(): void
    {
        $a = Username::fromString('hello44');
        $b = Username::fromString('hello44');
        $this->assertSame(true, $a->equals($b));
        $this->assertSame(true, $b->equals($a));
    }

    public function testDifferentInstanceValueAreNotEquals(): void
    {
        $a = Username::fromString('john.doe');
        $b = Username::fromString('jane.doe');
        $this->assertSame(false, $a->equals($b));
        $this->assertSame(false, $b->equals($a));
    }

    public function testStringValueEqualsInstanceValue(): void
    {
        $a = Username::fromString('hello55');
        $b = 'hello55';
        $this->assertSame(true, $a->equals($b));
    }
}
