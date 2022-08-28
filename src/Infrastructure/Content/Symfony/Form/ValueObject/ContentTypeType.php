<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\ValueObject;

use Domain\Content\ValueObject\ContentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContentTypeType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContentTypeType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('content_type', ChoiceType::class, [
            'multiple' => false,
            'choices' => [],
        ])->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => ContentType::class,
            'empty_data' => null,
        ]);

        return $resolver;
    }

    /**
     * @param ContentType $viewData
     */
    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['content_type']->setData((string) $viewData);
    }

    /**
     * @param ContentType $viewData
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);
        try {
            $viewData = ContentType::fromString(strval($forms['content_type']->getData()));
        } catch (\InvalidArgumentException $e) {
            $forms['content_type']->addError(new FormError($e->getMessage()));
        }
    }
}
