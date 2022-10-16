<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PostSeriesController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/posts/series', 'administration_content_post_series_')]
final class PostSeriesController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'post_series';
}
