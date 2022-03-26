<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class AbstractCrudController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractCrudController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected EventDispatcherInterface $dispatcher,
        protected RequestStack $requestStack
    ) {
    }
}
