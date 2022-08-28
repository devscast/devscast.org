<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Domain\Content\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class CommentForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CommentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
            'translation_domain' => 'content',
        ]);
    }
}
