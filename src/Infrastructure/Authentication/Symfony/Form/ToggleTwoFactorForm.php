<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form;

use Application\Authentication\Command\ToggleTwoFactorCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ToggleTwoFactorForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ToggleTwoFactorForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', CheckboxType::class, [
                'label' => 'authentication.forms.labels.two_factor_email_provider',
                'required' => false,
            ])
            ->add('google', CheckboxType::class, [
                'label' => 'authentication.forms.labels.two_factor_google_authenticator_provider',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ToggleTwoFactorCommand::class,
            'translation_domain' => 'authentication',
        ]);
    }
}
