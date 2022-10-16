<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class TechnologieController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/technologies', 'administration_content_technologie_')]
final class TechnologieController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'technologie';
}
