<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdatePodcastSeasonCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UpdatePodcastSeasonForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdatePodcastSeasonCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}