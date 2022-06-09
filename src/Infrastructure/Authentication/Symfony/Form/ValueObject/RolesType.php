<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form\ValueObject;

use Domain\Authentication\ValueObject\Roles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RolesType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RolesType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('roles', ChoiceType::class, [
            'multiple' => true,
            'choices' => Roles::ROLES_CHOICES,
        ])->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => Roles::class,
            'empty_data' => null,
        ]);

        return $resolver;
    }

    /**
     * @param Roles $viewData
     */
    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['roles']->setData($viewData->toArray());
    }

    /**
     * @param Roles $viewData
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);
        try {
            $viewData = Roles::fromArray((array) $forms['roles']->getData());
        } catch (\InvalidArgumentException $e) {
            $forms['roles']->addError(new FormError($e->getMessage()));
        }
    }
}
