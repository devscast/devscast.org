<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form;

use Application\Authentication\Command\RequestLoginLinkCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RequestLoginLinkForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RequestLoginLinkForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', EmailType::class, [
            'label' => 'authentication.forms.labels.email',
            'attr' => [
                'autocomplete' => 'email',
                'placeholder' => 'authentication.forms.placeholders.email',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RequestLoginLinkCommand::class,
            'translation_domain' => 'authentication',
        ]);
    }
}
