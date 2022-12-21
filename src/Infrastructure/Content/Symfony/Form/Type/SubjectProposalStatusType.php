<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form\Type;

use Domain\Content\ValueObject\SubjectProposalStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SubjectProposalStatusType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class SubjectProposalStatusType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('status', ChoiceType::class, [
            'label' => 'content.forms.labels.subject_proposal_status',
            'multiple' => false,
            'choices' => SubjectProposalStatus::CHOICES,
            'autocomplete' => true,
        ])->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => SubjectProposalStatus::class,
            'empty_data' => null,
        ]);

        return $resolver;
    }

    /**
     * @param SubjectProposalStatus $viewData
     */
    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['status']->setData((string) $viewData);
    }

    /**
     * @param SubjectProposalStatus $viewData
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);
        try {
            $viewData = SubjectProposalStatus::fromString(strval($forms['status']->getData()));
        } catch (\InvalidArgumentException $e) {
            $forms['status']->addError(new FormError($e->getMessage()));
        }
    }
}
