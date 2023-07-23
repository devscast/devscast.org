<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Post;

use Domain\Content\Entity\Post;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('AppPostCard', template: '@app/shared/component/post/card.html.twig')]
final class PostCard
{
    public Post $post;
}
