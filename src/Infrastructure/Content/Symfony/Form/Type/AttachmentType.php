<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Type;

use Domain\Content\Entity\Attachment;
use Domain\Content\Repository\AttachmentRepositoryInterface;
use Infrastructure\Content\Symfony\Validator\AttachmentExist;
use Infrastructure\Content\Symfony\Validator\NonExistingAttachment;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * class AttachmentType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class AttachmentType extends TextType implements DataTransformerInterface
{
    public function __construct(
        private readonly AttachmentRepositoryInterface $repository,
        private readonly UploaderHelper $uploaderHelper,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addViewTransformer($this);
        parent::buildForm($builder, $options);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if (null !== $form->getData()) {
            $view->vars['attr']['preview'] = $this->uploaderHelper->asset($form->getData());
        }
        $view->vars['attr']['overwrite'] = true;
        parent::buildView($view, $form, $options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'required' => false,
            'attr' => [
                'is' => 'app-input-attachment',
                'data-endpoint' => 'http://localhost:8000/api/content/attachment',
            ],
            'constraints' => [
                new AttachmentExist(),
            ],
        ]);
        parent::configureOptions($resolver);
    }

    /**
     * @param ?Attachment $data
     */
    public function transform(mixed $data): ?int
    {
        if ($data instanceof Attachment) {
            return $data->getId();
        }

        return null;
    }

    public function reverseTransform(mixed $data): ?Attachment
    {
        if (empty($data)) {
            return null;
        }

        return $this->repository->find($data) ?: new NonExistingAttachment(intval($data));
    }
}
