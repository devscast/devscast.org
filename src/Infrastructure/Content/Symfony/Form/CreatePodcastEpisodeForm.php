<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\CreatePodcastEpisodeCommand;
use Domain\Content\Entity\PodcastSeason;
use Infrastructure\Content\Symfony\Form\ValueObject\PodcastEpisodeTypeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

final class CreatePodcastEpisodeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //$builder->add('');

        // podcast episode
        $builder
            ->add('audio_file', DropzoneType::class, [
                'label' => 'content.forms.labels.audio',
            ])
            ->add('season', EntityType::class, [
                'label' => 'content.forms.labels.season',
                'class' => PodcastSeason::class,
                'choice_label' => 'name',
                'required' => false,
                'autocomplete' => true,
            ])
            ->add('episode_type', PodcastEpisodeTypeType::class, [
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreatePodcastEpisodeCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
