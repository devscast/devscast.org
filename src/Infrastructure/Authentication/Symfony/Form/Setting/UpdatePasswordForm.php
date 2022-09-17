<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form\Setting;

use Application\Authentication\Command\UpdatePasswordCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdatePasswordForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePasswordForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var UpdatePasswordCommand|null $command */
        $command = $builder->getData();

        if ($command && null !== $command->user->getPassword()) {
            $builder->add('current', PasswordType::class, [
                'label' => 'authentication.forms.labels.current_password',
            ]);
        }

        $builder->add('new', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'authentication.validations.password_must_match',
            'required' => true,
            'first_options' => [
                'label' => 'authentication.forms.labels.password',
                'attr' => [
                    'minlength' => 6,
                ],
            ],
            'second_options' => [
                'label' => 'authentication.forms.labels.password_confirm',
                'attr' => [
                    'minlength' => 6,
                ],
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdatePasswordCommand::class,
            'translation_domain' => 'authentication',
        ]);
    }
}
