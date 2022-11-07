<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\CreatePostCommand;
use Domain\Content\Entity\Category;
use Domain\Content\Entity\PostSeries;
use Infrastructure\Content\Symfony\Form\Type\AbstractContentType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class CreatePostForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CreatePostForm extends AbstractContentType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addContentFields($builder);
        $builder
            ->add('category', EntityType::class, [
                'label' => 'content.forms.labels.category',
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => false,
                'autocomplete' => true,
            ])
            ->add('series', EntityType::class, [
                'label' => 'content.forms.labels.series',
                'class' => PostSeries::class,
                'choice_label' => 'name',
                'required' => false,
                'autocomplete' => true,
            ]);
        $this->addContentOptions($builder);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreatePostCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
