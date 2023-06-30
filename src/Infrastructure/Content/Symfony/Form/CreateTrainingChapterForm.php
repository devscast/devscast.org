<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\CreateTrainingChapterCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Form\Type\EditorType;
use Domain\Content\Entity\Video;
use Infrastructure\Content\Symfony\Form\Type\AbstractContentType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

/**
 * class CreateTrainingChapterForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CreateTrainingChapterForm extends AbstractContentType
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
            ->add('thumbnail_file', DropzoneType::class, [
                'label' => 'content.forms.labels.thumbnail',
                'required' => ! $this->isEdition($builder),
            ])
            ->add('order', IntegerType::class, [
                'label' => 'content.forms.labels.order',
                'required' => false,
            ])
            ->add('videos', EntityType::class, [
                'label' => 'content.forms.labels.videos',
                'class' => Video::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'autocomplete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateTrainingChapterCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
