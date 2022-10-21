<?php

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdateTrainingCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UpdateTrainingForm extends AbstractType
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
