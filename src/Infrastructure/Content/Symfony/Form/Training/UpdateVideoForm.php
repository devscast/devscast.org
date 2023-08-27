<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Training;

use Application\Content\Command\Training\UpdateVideoCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdateVideoForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateVideoForm extends CreateVideoForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateVideoCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
