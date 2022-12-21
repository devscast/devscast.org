<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Form;

use Application\Content\Command\UpdateSubjectProposalCommand;
use Infrastructure\Content\Symfony\Form\Type\SubjectProposalStatusType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdateSubjectProposalForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateSubjectProposalForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var UpdateSubjectProposalCommand $data */
        $data = $builder->getData();

        $builder
            ->add('subject', TextType::class, [
                'label' => 'content.forms.labels.title',
                'disabled' => true,
                'attr' => [
                    'value' => $data->state->subject,
                ],
            ])
            ->add('status', SubjectProposalStatusType::class, [
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateSubjectProposalCommand::class,
            'translation_domain' => 'content',
        ]);
    }
}
