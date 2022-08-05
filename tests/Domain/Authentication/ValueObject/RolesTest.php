<?php

declare(strict_types=1);

namespace Tests\Domain\Authentication\ValueObject;

use Domain\Authentication\ValueObject\Roles;
use PHPUnit\Framework\TestCase;

/**
 * Class RolesTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RolesTest extends TestCase
{
    public function testInstanceValueHasExceptedOptions(): void
    {
        $roles = ['ROLE_ADMIN', 'ROLE_USER', 'ROLE_SUPER_ADMIN', 'ROLE_CONTENT_MANAGER'];
        foreach ($roles as $role) {
            $this->assertContains($role, Roles::VALUES);
        }
    }

    public function testCreateRolesWithEmptyArray(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('authentication.validations.empty_roles');
        Roles::fromArray([]);
    }

    public function testCreateRolesWithInvalidOption(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('authentication.validations.invalid_role');
        Roles::fromArray(['invalid']);
    }

    public function testSameInstanceValueAreEquals(): void
    {
        $a = Roles::developer();
        $b = Roles::developer();
        $this->assertSame(true, $a->equals($b));
        $this->assertSame(true, $b->equals($a));
    }

    public function testDifferentInstanceValueAreNotEquals(): void
    {
        $a = Roles::developer();
        $b = Roles::superAdmin();
        $this->assertSame(false, $a->equals($b));
        $this->assertSame(false, $b->equals($a));
    }

    public function testArrayValueEqualsInstanceValue(): void
    {
        $a = Roles::developer();
        $b = ['ROLE_USER'];
        $this->assertSame(true, $a->equals($b));
    }

    public function testArrayValuesAreNotEqualsToInstanceValue(): void
    {
        $a = Roles::developer();
        $b = ['ROLE_USER', 'ROLE_ADMIN'];
        $this->assertSame(false, $a->equals($b));
    }
}
