<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\CreateTrainingCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Form\Type\AutoGrowTextareaType;
use Infrastructure\Content\Symfony\Form\Type\AbstractContentType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class CreateTrainingForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CreateTrainingForm extends AbstractContentType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addContentFields($builder);
        $builder
            ->add('youtube_playlist', UrlType::class, [
                'label' => 'content.forms.labels.youtube_playlist',
                'required' => false,
            ])
            ->add('links', AutoGrowTextareaType::class, [
                'label' => 'content.forms.labels.links',
                'required' => false,
            ]);
        $this->addContentOptions($builder);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateTrainingCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
