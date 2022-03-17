<?php

declare(strict_types=1);

namespace Tests;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class RepositoryTestCase
 * @package App\Tests
 * @author bernard-ng <bernard@devscast.tech>
 */
class RepositoryTestCase extends KernelTestCase
{
    protected ?ServiceEntityRepository $repository = null;
    protected ?string $repositoryClass = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = self::getContainer()->get($this->repositoryClass);
    }
}
