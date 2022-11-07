<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\CreatePostListCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class CreatePostListForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CreatePostListForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'content.forms.labels.name',
            ])
            ->add('description', null, [
                'label' => 'content.forms.labels.description',
                'required' => false,
            ])
            ->add('is_public', CheckboxType::class, [
                'label' => 'content.forms.labels.is_public',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreatePostListCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
