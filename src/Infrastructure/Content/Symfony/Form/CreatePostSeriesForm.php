<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\CreatePostSeriesCommand;
use Domain\Content\Entity\Technology;
use Infrastructure\Content\Symfony\Form\Type\AbstractContentType;
use Infrastructure\Content\Symfony\Form\Type\TagType;
use Infrastructure\Shared\Symfony\Form\Type\EditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

/**
 * class CreatePostSeriesForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CreatePostSeriesForm extends AbstractContentType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'content.forms.labels.name',
            ])
            ->add('description', EditorType::class, [
                'label' => 'content.forms.labels.description',
                'required' => false,
            ])
            ->add('technology', EntityType::class, [
                'class' => Technology::class,
                'choice_label' => 'name',
                'label' => 'content.forms.labels.technology',
                'autocomplete' => true,
                'required' => false,
            ])
            ->add('tags', TagType::class, [
                'label' => 'content.forms.labels.tags',
                'required' => false,
            ])
            ->add('thumbnail_file', DropzoneType::class, [
                'label' => 'content.forms.labels.thumbnail',
                'required' => ! $this->isEdition($builder),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreatePostSeriesCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
