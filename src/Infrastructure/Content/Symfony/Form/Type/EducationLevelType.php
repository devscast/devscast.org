<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Type;

use Domain\Content\Enum\EducationLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EducationLevelType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class EducationLevelType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('education_level', ChoiceType::class, [
            'label' => 'content.forms.labels.education_level',
            'multiple' => false,
            'choices' => EducationLevel::choices(),
            'autocomplete' => true,
        ])->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => EducationLevel::class,
            'empty_data' => null,
            'translation_domain' => 'content',
        ]);

        return $resolver;
    }

    /**
     * @param EducationLevel $viewData
     */
    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['education_level']->setData($viewData->value);
    }

    /**
     * @param EducationLevel $viewData
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);
        try {
            /** @var string $level */
            $level = $forms['education_level']->getData();
            $viewData = EducationLevel::from($level);
        } catch (\InvalidArgumentException $e) {
            $forms['education_level']->addError(new FormError($e->getMessage()));
        }
    }
}