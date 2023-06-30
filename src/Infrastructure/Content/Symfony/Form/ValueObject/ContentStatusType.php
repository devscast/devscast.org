<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\ValueObject;

use Domain\Content\ValueObject\ContentStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContentStatusType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContentStatusType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('content_type', ChoiceType::class, [
            'label' => 'content.forms.labels.content_status',
            'multiple' => false,
            'choices' => ContentStatus::CHOICES,
            'autocomplete' => true,
        ])->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => ContentStatus::class,
            'empty_data' => null,
            'translation_domain' => 'content',
        ]);

        return $resolver;
    }

    /**
     * @param ContentStatus $viewData
     */
    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['content_type']->setData((string) $viewData);
    }

    /**
     * @param ContentStatus $viewData
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);
        try {
            /** @var string $status */
            $status = $forms['content_type']->getData();
            $viewData = ContentStatus::fromString($status);
        } catch (\InvalidArgumentException $e) {
            $forms['content_type']->addError(new FormError($e->getMessage()));
        }
    }
}
