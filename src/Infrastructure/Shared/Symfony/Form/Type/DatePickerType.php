<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DatePickerType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class DatePickerType extends DateTimeType
{
    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'attr' => [
                'is' => 'app-datepicker',
            ],
            'input_format' => 'Y-m-d H:i',
            'html5' => false,
            'widget' => 'single_text',
        ]);

        return $resolver;
    }
}
