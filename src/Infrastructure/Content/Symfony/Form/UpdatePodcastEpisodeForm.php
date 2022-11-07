<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdatePodcastEpisodeCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdatePodcastEpisodeForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class UpdatePodcastEpisodeForm extends CreatePodcastEpisodeForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdatePodcastEpisodeCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
