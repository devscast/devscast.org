<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\CreateCommentCommand;
use Infrastructure\Shared\Symfony\Form\Type\AutoGrowTextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class CreateCommentForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CreateCommentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('content', AutoGrowTextareaType::class, [
            'label' => 'content.forms.labels.content',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateCommentCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
