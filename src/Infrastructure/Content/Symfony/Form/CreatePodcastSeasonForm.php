<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\CreatePodcastSeasonCommand;
use Infrastructure\Shared\Symfony\Form\Type\EditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class CreatePodcastSeasonForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CreatePodcastSeasonForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'content.forms.labels.name',
            ])
            ->add('short_code', TextType::class, [
                'label' => 'content.forms.labels.short_code',
            ])
            ->add('description', EditorType::class, [
                'label' => 'content.forms.labels.description',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreatePodcastSeasonCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
