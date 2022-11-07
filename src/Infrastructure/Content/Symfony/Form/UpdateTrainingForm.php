<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdateTrainingCommand;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdateTrainingForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateTrainingForm extends CreateTrainingForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateTrainingCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
