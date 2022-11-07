<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdateCategoryCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdateCategoryForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateCategoryForm extends CreateCategoryForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateCategoryCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
