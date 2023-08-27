<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Blog;

use Application\Content\Command\Blog\CreatePostCommand;
use Domain\Content\Entity\Blog\Category;
use Infrastructure\Content\Symfony\Form\Type\AbstractContentType;
use Infrastructure\Content\Symfony\Form\Type\AttachmentType;
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
            ->add('attachment', AttachmentType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'label' => 'content.forms.labels.category',
                'class' => Category::class,
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
