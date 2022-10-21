<?php

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\CreatePodcastSeasonCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreatePodcastSeasonForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreatePodcastSeasonCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
