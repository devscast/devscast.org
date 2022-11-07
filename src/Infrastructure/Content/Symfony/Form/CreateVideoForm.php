<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\CreateVideoCommand;
use Domain\Content\Entity\Training;
use Infrastructure\Content\Symfony\Form\Type\AbstractContentType;
use Infrastructure\Shared\Symfony\Form\Type\AutoGrowTextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class CreateVideoForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CreateVideoForm extends AbstractContentType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addContentFields($builder);
        $builder
            ->add('source_url', UrlType::class, [
                'label' => 'content.forms.labels.source_url',
            ])
            ->add('timecodes', AutoGrowTextareaType::class, [
                'label' => 'content.forms.labels.timecodes',
                'required' => false,
            ])
            ->add('training', EntityType::class, [
                'class' => Training::class,
                'choice_label' => 'name',
                'label' => 'content.forms.labels.training',
                'required' => false,
                'autocomplete' => true,
            ]);

        $this->addContentOptions($builder);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateVideoCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
