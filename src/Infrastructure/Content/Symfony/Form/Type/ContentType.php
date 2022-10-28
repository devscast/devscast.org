<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Type;

use Application\Content\Command\AbstractContentCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AbstractContentCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
