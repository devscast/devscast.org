<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\ValueObject;

use Domain\Content\ValueObject\PodcastEpisodeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PodcastEpisodeTypeType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class PodcastEpisodeTypeType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('episode_type', ChoiceType::class, [
            'multiple' => false,
            'choices' => PodcastEpisodeType::CHOICES,
        ])->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => PodcastEpisodeType::class,
            'empty_data' => null,
            'translation_domain' => 'content'
        ]);

        return $resolver;
    }

    /**
     * @param PodcastEpisodeType $viewData
     */
    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['episode_type']->setData((string) $viewData);
    }

    /**
     * @param PodcastEpisodeType $viewData
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);
        try {
            $viewData = PodcastEpisodeType::fromString(strval($forms['episode_type']->getData()));
        } catch (\InvalidArgumentException $e) {
            $forms['episode_type']->addError(new FormError($e->getMessage()));
        }
    }
}
