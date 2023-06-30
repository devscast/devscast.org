<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Symfony\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class HintFormExtension.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class HintFormExtension extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [TextType::class];
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['hint_text'] = $options['hint_text'] ?? '';
        $view->vars['hint_icon'] = $options['hint_icon'] ?? '';
        $view->vars['hint_icon_alignment'] = $options['hint_icon_alignment'] ?? '';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'hint_text' => null,
            'hint_icon' => null,
            'hint_icon_alignment' => 'right',
        ]);
        $resolver->setAllowedValues('hint_icon_alignment', ['left', 'right']);
    }
}
