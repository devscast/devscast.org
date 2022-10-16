<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PostListController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/posts/lists', 'administration_content_post_list_')]
final class PostListController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'post_list';
}
