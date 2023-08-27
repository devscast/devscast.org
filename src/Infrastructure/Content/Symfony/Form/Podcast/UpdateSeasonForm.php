<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Podcast;

use Application\Content\Command\Podcast\UpdateSeasonCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdatePodcastSeasonForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateSeasonForm extends CreateSeasonForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateSeasonCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
