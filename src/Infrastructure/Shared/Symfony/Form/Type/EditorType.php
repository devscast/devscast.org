<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AutoGrowTextareaType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class EditorType extends TextareaType
{
    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'html5' => false,
            'row_attr' => [
                'class' => 'full',
            ],
            'attr' => [
                'is' => 'app-markdown-editor',
            ],
        ]);

        return $resolver;
    }
}
