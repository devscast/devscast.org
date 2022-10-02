<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form\ValueObject;

use Domain\Authentication\ValueObject\RssUrl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RssUrlType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RssUrlType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('rss_url', UrlType::class, [
            'label' => 'authentication.forms.labels.rss_url',
        ])->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => RssUrl::class,
            'empty_data' => null,
        ]);

        return $resolver;
    }

    /**
     * @param RssUrl $viewData
     */
    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['rss_url']->setData((string) $viewData);
    }

    /**
     * @param RssUrl $viewData
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);
        try {
            $viewData = RssUrl::fromString(strval($forms['rss_url']->getData()));
        } catch (\InvalidArgumentException $e) {
            $forms['rss_url']->addError(new FormError($e->getMessage()));
        }
    }
}
