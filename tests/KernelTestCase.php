<?php

declare(strict_types=1);

namespace Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

/**
 * Class KernelTestCase
 * @package Tests
 * @author bernard-ng <bernard@devscast.tech>
 */
class KernelTestCase extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    protected KernelBrowser $client;
    protected EntityManagerInterface $em;

    public function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        parent::setUp();
    }

    public function remove(object $entity): void
    {
        $this->em->remove($this->em->getRepository(get_class($entity))->find($entity->getId()));
    }
}
