<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form\Type;

use Domain\Authentication\Enum\Gender;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GenderType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class GenderType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('gender', ChoiceType::class, [
            'label' => 'authentication.forms.labels.gender',
            'multiple' => false,
            'choices' => Gender::choices(),
            'autocomplete' => true,
        ])->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => Gender::class,
            'empty_data' => null,
            'translation_domain' => 'authentication',
        ]);

        return $resolver;
    }

    /**
     * @param Gender $viewData
     */
    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['gender']->setData($viewData->value);
    }

    /**
     * @param Gender $viewData
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);
        try {
            /** @var string $gender */
            $gender = $forms['gender']->getData();
            $viewData = Gender::from($gender);
        } catch (\InvalidArgumentException $e) {
            $forms['gender']->addError(new FormError($e->getMessage()));
        }
    }
}
