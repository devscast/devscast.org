<?php

declare(strict_types=1);

namespace Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;
use Nelmio\Alice\Throwable\LoadingThrowable;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class AppFixtures
 *
 * allows to import fixtures in yaml format
 * while keeping the possibility to use fixtures in php if needed
 *
 * @package App\Fixtures
 * @author bernard-ng <bernard@devscast.tech>
 */
class AppFixtures extends Fixture
{
    public function __construct(private KernelInterface $kernel)
    {
    }

    /**
     * @throws LoadingThrowable
     */
    public function load(ObjectManager $manager): void
    {
        if ($this->kernel->getEnvironment() === 'dev') {
            $loader = new NativeLoader();
            $entities = $loader
                ->loadFile($this->kernel->getProjectDir() . '/fixtures/data/fixtures.yaml')
                ->getObjects();

            foreach ($entities as $entity) {
                $manager->persist($entity);
            };
            $manager->flush();
        }
    }
}
