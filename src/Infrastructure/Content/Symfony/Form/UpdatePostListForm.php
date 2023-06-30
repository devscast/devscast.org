<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdatePostListCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdatePostListForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePostListForm extends CreatePostListForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdatePostListCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
