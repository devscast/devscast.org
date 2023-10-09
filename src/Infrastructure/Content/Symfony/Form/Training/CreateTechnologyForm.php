<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Training;

use Application\Content\Command\Training\CreateTechnologyCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Form\Type\EditorType;
use Infrastructure\Content\Symfony\Form\Type\AbstractContentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

/**
 * class CreateTechnologyForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CreateTechnologyForm extends AbstractContentType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'content.forms.labels.name',
            ])
            ->add('slug', TextType::class, [
                'label' => 'content.forms.labels.slug',
                'required' => false,
            ])
            ->add('description', EditorType::class, [
                'label' => 'content.forms.labels.description',
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
            'data_class' => CreateTechnologyCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}