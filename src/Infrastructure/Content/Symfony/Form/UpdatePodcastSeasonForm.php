<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdatePodcastSeasonCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdatePodcastSeasonForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePodcastSeasonForm extends CreatePodcastSeasonForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdatePodcastSeasonCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
