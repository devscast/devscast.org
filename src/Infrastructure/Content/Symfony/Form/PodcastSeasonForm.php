<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Domain\Content\Entity\PodcastSeason;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class PodcastSeasonForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class PodcastSeasonForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PodcastSeason::class,
            'translation_domain' => 'content',
        ]);
    }
}
