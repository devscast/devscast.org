<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form\Setting;

use Application\Authentication\Command\Toggle2FACommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Toggle2FaForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Toggle2FaForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', CheckboxType::class, [
                'label' => 'authentication.forms.labels.2fa_email_provider',
                'required' => false,
            ])
            ->add('google', CheckboxType::class, [
                'label' => 'authentication.forms.labels.2fa_google_authenticator_provider',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Toggle2FACommand::class,
            'translation_domain' => 'authentication',
        ]);
    }
}
