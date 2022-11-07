<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdateCommentCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdateCommentForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateCommentForm extends CreateCommentForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateCommentCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
