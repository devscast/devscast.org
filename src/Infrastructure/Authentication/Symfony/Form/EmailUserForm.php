<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form;

use Application\Authentication\Command\EmailUserCommand;
use Infrastructure\Shared\Symfony\Form\Type\AutoGrowTextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class EmailUserForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class EmailUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, [
                'label' => 'authentication.forms.labels.subject',
            ])
            ->add('message', AutoGrowTextareaType::class, [
                'label' => 'authentication.forms.labels.message',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmailUserCommand::class,
            'translation_domain' => 'authentication',
        ]);
    }
}
