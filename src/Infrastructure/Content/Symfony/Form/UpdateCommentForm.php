<?php

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdateCommentCommand;
use Infrastructure\Shared\Symfony\Form\Type\AutoGrowTextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdateCommentForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateCommentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('content', AutoGrowTextareaType::class, [
            'label' => 'content.forms.labels.content'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateCommentCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
