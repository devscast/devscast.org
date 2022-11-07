<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdateVideoCommand;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdateVideoForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateVideoForm extends CreateVideoForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateVideoCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
