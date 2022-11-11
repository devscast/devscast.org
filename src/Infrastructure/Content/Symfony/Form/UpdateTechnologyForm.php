<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdateTechnologyCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdateTechnologyForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateTechnologyForm extends CreateTechnologyForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateTechnologyCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
