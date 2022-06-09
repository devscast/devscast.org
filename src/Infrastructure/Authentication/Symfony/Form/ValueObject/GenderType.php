<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form\ValueObject;

use Domain\Authentication\ValueObject\Gender;
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
            'multiple' => false,
            'choices' => Gender::GENDERS_CHOICES,
        ])->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => Gender::class,
            'empty_data' => null,
        ]);

        return $resolver;
    }

    /**
     * @param Gender $viewData
     */
    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['username']->setData((string) $viewData);
    }

    /**
     * @param Gender $viewData
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);
        try {
            $viewData = Gender::fromString(strval($forms['gender']->getData()));
        } catch (\InvalidArgumentException $e) {
            $forms['gender']->addError(new FormError($e->getMessage()));
        }
    }
}
