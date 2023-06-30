<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form;

use Application\Authentication\Command\LoginCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * Class LoginForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginForm extends AbstractType
{
    public function __construct(
        private readonly CsrfTokenManagerInterface $csrfTokenManager
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('identifier', TextType::class, [
                'label' => null,
                'attr' => [
                    'placeholder' => 'authentication.forms.labels.identifier',
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => null,
                'attr' => [
                    'placeholder' => 'authentication.forms.labels.password',
                    'autocomplete' => 'current-password',
                ],
            ])
            ->add('_token', HiddenType::class, [
                'mapped' => false,
                'attr' => [
                    'value' => $this->csrfTokenManager->getToken('authenticate')->getValue(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LoginCommand::class,
            'csrf_protection' => false,
            'translation_domain' => 'authentication',
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
