<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form\Type;

use Domain\Authentication\ValueObject\Username;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UsernameType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('username', TextType::class, [
            'label' => false,
            //'authentication.forms.labels.username',
            'attr' => [
                'placeholder' => 'authentication.forms.labels.placeholders.username',
            ],
        ])->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => Username::class,
            'empty_data' => null,
            'translation_domain' => 'authentication',
        ]);

        return $resolver;
    }

    /**
     * @param Username $viewData
     */
    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['username']->setData((string) $viewData);
    }

    /**
     * @param Username $viewData
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);
        try {
            /** @var string $username */
            $username = $forms['username']->getData();
            $viewData = Username::fromString($username);
        } catch (\InvalidArgumentException $e) {
            $forms['username']->addError(new FormError($e->getMessage()));
        }
    }
}
