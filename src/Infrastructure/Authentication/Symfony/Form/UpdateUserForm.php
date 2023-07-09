<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form;

use Application\Authentication\Command\UpdateUserCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Form\Type\AutoGrowTextareaType;
use Infrastructure\Authentication\Symfony\Form\ValueObject\GenderType;
use Infrastructure\Authentication\Symfony\Form\ValueObject\RolesType;
use Infrastructure\Authentication\Symfony\Form\ValueObject\RssUrlType;
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
 * class UpdateUserForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateUserForm extends CreateUserForm
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateUserCommand::class,
            'translation_domain' => 'authentication',
        ]);
    }
}
