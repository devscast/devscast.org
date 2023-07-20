<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form;

use Application\Authentication\Command\CreateUserCommand;
use Application\Authentication\Command\UpdateUserCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Form\Type\AutoGrowTextareaType;
use Infrastructure\Authentication\Symfony\Form\ValueObject\GenderType;
use Infrastructure\Authentication\Symfony\Form\ValueObject\RolesType;
use Infrastructure\Authentication\Symfony\Form\ValueObject\RssUrlType;
use Infrastructure\Authentication\Symfony\Form\ValueObject\UsernameType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

/**
 * class CreateUserForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CreateUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEditMode = $builder->getData() instanceof UpdateUserCommand;

        if (! $isEditMode) {
            $builder
                ->add('username', UsernameType::class, [
                    'label' => false,
                ]);
        }

        $builder->add('email', EmailType::class, [
            'label' => 'authentication.forms.labels.email',
            'row_attr' => [
                'class' => 'col-12 col-md-4',
            ],
        ])
            ->add('name', TextType::class, [
                'label' => 'authentication.forms.labels.name',
                'required' => false,
                'row_attr' => [
                    'class' => 'col-12 col-md-4',
                ],
            ])
            ->add('gender', GenderType::class, [
                'label' => false,
                'required' => false,
                'row_attr' => [
                    'class' => 'col-12 col-md-4',
                ],
            ])
            ->add('avatar_file', DropzoneType::class, [
                'label' => 'authentication.forms.labels.avatar',
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
                'attr' => [
                    'is' => 'app-select-choices',
                ],
            ])
            ->add('linkedin_url', UrlType::class, [
                'label' => 'authentication.forms.labels.linkedin_url',
                'required' => false,
                'row_attr' => [
                    'class' => 'col-12 col-md-6',
                ],
            ])
            ->add('github_url', UrlType::class, [
                'label' => 'authentication.forms.labels.github_url',
                'required' => false,
                'row_attr' => [
                    'class' => 'col-12 col-md-6',
                ],
            ])
            ->add('twitter_url', UrlType::class, [
                'label' => 'authentication.forms.labels.twitter_url',
                'required' => false,
                'row_attr' => [
                    'class' => 'col-12 col-md-6',
                ],
            ])
            ->add('website_url', UrlType::class, [
                'label' => 'authentication.forms.labels.website_url',
                'required' => false,
                'row_attr' => [
                    'class' => 'col-12 col-md-6',
                ],
            ])
            ->add('rss_url', RssUrlType::class, [
                'label' => false,
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
            ->add('is_dark_theme', CheckboxType::class, [
                'label' => 'authentication.forms.labels.is_dark_theme',
                'required' => false,
            ])
            ->add('roles', RolesType::class, [
                'label' => false,
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
