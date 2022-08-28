<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Domain\Content\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class CategoryForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CategoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'translation_domain' => 'content',
        ]);
    }
}
