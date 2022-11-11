<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdatePostSeriesCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdatePostSeriesForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePostSeriesForm extends CreatePostSeriesForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdatePostSeriesCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
