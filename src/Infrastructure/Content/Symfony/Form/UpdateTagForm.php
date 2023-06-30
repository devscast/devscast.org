<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdateTagCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdateTagForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateTagForm extends CreateTagForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateTagCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
