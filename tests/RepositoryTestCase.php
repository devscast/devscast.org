<?php

declare(strict_types=1);

namespace Tests;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class RepositoryTestCase.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class RepositoryTestCase extends KernelTestCase
{
    protected ?ServiceEntityRepository $repository = null;
    protected ?string $repositoryClass = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = self::getContainer()->get($this->repositoryClass);
    }
}
