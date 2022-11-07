<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdatePostCommand;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdatePostForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePostForm extends CreatePostForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdatePostCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
