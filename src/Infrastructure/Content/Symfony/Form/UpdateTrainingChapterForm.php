<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdateTrainingChapterCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdateTrainingChapterForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateTrainingChapterForm extends CreateTrainingChapterForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateTrainingChapterCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
