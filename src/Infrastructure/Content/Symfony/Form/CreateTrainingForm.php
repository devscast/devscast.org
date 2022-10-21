<?php

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\CreateTrainingCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreateTrainingForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateTrainingCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
