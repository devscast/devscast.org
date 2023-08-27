<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Blog;

use Application\Content\Command\Blog\UpdatePostCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdatePostForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePostForm extends CreatePostForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdatePostCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
