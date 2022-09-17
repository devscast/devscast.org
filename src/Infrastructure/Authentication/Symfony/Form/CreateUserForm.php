<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form;

use Application\Authentication\Command\CreateUserCommand;
use Infrastructure\Authentication\Symfony\Form\ValueObject\UsernameType;
use Infrastructure\Shared\Symfony\Form\Type\AutoGrowTextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class CreateUserForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', UsernameType::class, [
                'label' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'authentication.forms.labels.email',
            ])
            ->add('name', TextType::class, [
                'label' => 'authentication.forms.labels.name',
                'required' => false,
            ])
            ->add('job_title', TextType::class, [
                'label' => 'authentication.forms.labels.job_title',
                'required' => false,
            ])
            ->add('biography', AutoGrowTextareaType::class, [
                'label' => 'authentication.forms.labels.biography',
                'required' => false,
            ])
            ->add('pronouns', TextType::class, [
                'label' => 'authentication.forms.labels.pronouns',
                'required' => false,
            ])
            ->add('phone_number', TextType::class, [
                'label' => 'authentication.forms.labels.phone_number',
                'required' => false,
            ])
            ->add('country', CountryType::class, [
                'label' => 'authentication.forms.labels.country',
                'required' => false,
            ])
            ->add('is_subscribed_newsletter', CheckboxType::class, [
                'label' => 'authentication.forms.labels.is_subscribed_newsletter',
                'required' => false,
            ])
            ->add('is_subscribed_marketing', CheckboxType::class, [
                'label' => 'authentication.forms.labels.is_subscribed_marketing',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateUserCommand::class,
            'translation_domain' => 'authentication',
        ]);
    }
}
