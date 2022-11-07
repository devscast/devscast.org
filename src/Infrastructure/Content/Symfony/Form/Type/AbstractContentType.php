<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Type;

use Application\Content\Command\AbstractContentCommand;
use Application\Content\Command\CreatePodcastEpisodeCommand;
use Infrastructure\Shared\Symfony\Form\Type\DatePickerType;
use Infrastructure\Shared\Symfony\Form\Type\EditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

/**
 * class AbstractContentType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class AbstractContentType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreatePodcastEpisodeCommand::class,
            'translation_domain' => 'content',
        ]);
    }

    protected function addContentFields(FormBuilderInterface &$builder): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'content.forms.labels.name',
            ])
            ->add('slug', TextType::class, [
                'label' => 'content.forms.labels.slug',
                'required' => false,
            ])
            ->add('content', EditorType::class, [
                'label' => 'content.forms.labels.content',
            ])
            ->add('thumbnail_file', DropzoneType::class, [
                'label' => 'content.forms.labels.thumbnail',
                'required' => ! $this->isEdition($builder),
            ])
            ->add('tags', TagType::class)
            ->add('technologies', TechnologyType::class)
            ->add('scheduled_at', DatePickerType::class, [
                'label' => 'content.forms.labels.schedule',
                'required' => false,
            ])
        ;
    }

    protected function addContentOptions(FormBuilderInterface &$builder): void
    {
        $builder
            ->add('is_commentable', CheckboxType::class, [
                'label' => 'content.forms.labels.is_commentable',
                'required' => false,
            ])
            ->add('is_online', CheckboxType::class, [
                'label' => 'content.forms.labels.is_online',
                'required' => false,
            ])
            ->add('is_premium', CheckboxType::class, [
                'label' => 'content.forms.labels.is_premium',
                'required' => false,
            ])
            ->add('is_top_promoted', CheckboxType::class, [
                'label' => 'content.forms.labels.is_top_promoted',
                'required' => false,
            ])
            ->add('is_featured', CheckboxType::class, [
                'label' => 'content.forms.labels.is_featured',
                'required' => false,
            ])
        ;
    }

    protected function isEdition(FormBuilderInterface $builder): bool
    {
        $data = $builder->getData();

        return $data instanceof AbstractContentCommand && null !== $data->getId();
    }
}
