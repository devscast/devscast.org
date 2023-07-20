<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form;

use Application\Authentication\Command\UpdateUserCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
