<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Form\Field;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Domain\Authentication\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

/**
 * Class UserAutocompleteField.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsEntityAutocompleteField]
class UserAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => User::class,
            'autocomplete' => true,
            'choice_label' => 'username',
            'placeholder' => 'pseudo de l\'utilisateur',
            'filter_query' => function (QueryBuilder $qb, string $query, EntityRepository $repository) {
                if (! $query) {
                    return;
                }

                $qb->andWhere('entity.name LIKE :filter OR entity.username.username LIKE :filter')
                    ->setParameter('filter', '%' . $query . '%');
            },
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
