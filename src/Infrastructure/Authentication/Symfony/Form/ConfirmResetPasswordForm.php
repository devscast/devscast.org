<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form;

use Application\Authentication\Command\ConfirmResetPasswordCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ConfirmResetPasswordForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ConfirmResetPasswordForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'authentication.forms.labels.password',
            ],
            'second_options' => [
                'label' => 'authentication.forms.labels.password_confirm',
            ],
            'invalid_message' => 'authentication.validations.password_must_match',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConfirmResetPasswordCommand::class,
            'translation_domain' => 'authentication',
        ]);
    }
}
