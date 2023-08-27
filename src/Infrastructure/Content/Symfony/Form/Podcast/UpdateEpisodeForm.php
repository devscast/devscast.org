<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Podcast;

use Application\Content\Command\Podcast\UpdateEpisodeCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdatePodcastEpisodeForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class UpdateEpisodeForm extends CreateEpisodeForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateEpisodeCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
