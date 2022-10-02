<?php

declare(strict_types=1);

namespace Tests\Application\Shared;

use Application\Shared\Mapper;
use Domain\Authentication\Entity\User;
use Domain\Authentication\ValueObject\Username;
use PHPUnit\Framework\TestCase;

/**
 * class MapperTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class MapperTest extends TestCase
{
    public function testHydrateObjectProperties(): void
    {
        $source = (new User())
            ->setUsername(Username::fromString('johndoe'))
            ->setEmail('johndoe@johndoe.com')
            ->setJobTitle('developer')
        ;
        $dest = new class() {
            public ?string $email = null;
            public ?string $job_title = null;
        };

        Mapper::hydrate($source, $dest);

        $this->assertSame('johndoe@johndoe.com', $dest->email);
        $this->assertSame('developer', $dest->job_title);
    }

    public function testIgnorePropertiesShouldNotBeHydrated(): void
    {
        $source = (new User())
            ->setUsername(Username::fromString('johndoe'))
            ->setEmail('johndoe@johndoe.com')
            ->setJobTitle('developer')
        ;
        $dest = new class() {
            public ?string $email = null;
            public ?string $job_title = null;
        };

        Mapper::hydrate($source, $dest, ['job_title']);

        $this->assertSame(null, $dest->job_title);
        $this->assertSame('johndoe@johndoe.com', $dest->email);
    }
}
