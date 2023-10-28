<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Podcast;

use Application\Content\Command\Podcast\CreateEpisodeCommand;
use Domain\Content\Entity\Podcast\Season;
use Infrastructure\Authentication\Symfony\Form\Field\UserAutocompleteField;
use Infrastructure\Content\Symfony\Form\Type\AbstractContentType;
use Infrastructure\Content\Symfony\Form\Type\EpisodeTypeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

/**
 * class CreatePodcastEpisodeForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CreateEpisodeForm extends AbstractContentType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addContentFields($builder);
        $builder
            ->add('audio_file', DropzoneType::class, [
                'label' => 'content.forms.labels.audio',
                'required' => ! $this->isEdition($builder),
            ])
            ->add('season', EntityType::class, [
                'label' => 'content.forms.labels.season',
                'class' => Season::class,
                'choice_label' => 'name',
                'required' => false,
                'autocomplete' => true,
            ])
            ->add('episode_type', EpisodeTypeType::class, [
                'label' => false,
            ])
            ->add('episode_number', IntegerType::class, [
                'label' => 'content.forms.labels.episode_number',
            ])
            ->add('guests', UserAutocompleteField::class, [
                'label' => 'content.forms.labels.guests',
                'multiple' => true,
                'required' => false,
            ])
        ;
        $this->addContentOptions($builder);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateEpisodeCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
