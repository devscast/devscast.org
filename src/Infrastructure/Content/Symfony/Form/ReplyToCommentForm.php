<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\ReplyToCommentCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Form\Type\EditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ReplyToCommentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('content', EditorType::class, [
            'label' => 'content.forms.labels.content',
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReplyToCommentCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
