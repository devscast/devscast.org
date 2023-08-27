<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Post;

use Domain\Content\Entity\Blog\Post;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class AppPostCard.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(template: '@app/shared/component/post/card.html.twig')]
final class AppPostCard
{
    public Post $post;

    public function mount(Post $post): void
    {
        $this->post = $post;
    }
}
