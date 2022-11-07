<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\CreateCategoryCommand;
use Infrastructure\Shared\Symfony\Form\Type\AutoGrowTextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class CreateCategoryForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CreateCategoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'content.forms.labels.name',
            ])
            ->add('description', AutoGrowTextareaType::class, [
                'label' => 'content.forms.labels.description',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateCategoryCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
