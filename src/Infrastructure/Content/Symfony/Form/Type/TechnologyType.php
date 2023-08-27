<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Type;

use Domain\Content\Entity\Training\Technology;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class TechnologyType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TechnologyType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'label' => 'content.forms.labels.technology',
            'autocomplete' => true,
            'class' => Technology::class,
            'multiple' => true,
            'choice_label' => 'name',
            'required' => false,
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
