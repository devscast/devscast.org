<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Domain\Content\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class TagForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TagForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}
