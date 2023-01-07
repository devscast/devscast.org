<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Content;
use Domain\Content\Entity\ContentView;
use Domain\Content\Repository\ContentViewRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class ContentViewRepository.
 *
 * @extends AbstractRepository<ContentView>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContentViewRepository extends AbstractRepository implements ContentViewRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContentView::class);
    }

    public function isContentAlreadyViewed(Content $target, string $ip, ?User $owner): bool
    {
        try {
            $this->createQueryBuilder('cv')
                ->where('(cv.target = :target AND cv.ip = :ip) OR (cv.target = :target AND cv.owner = :owner)')
                ->setParameter('target', $target)
                ->setParameter('ip', $ip)
                ->setParameter('owner', $owner)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException) {
            return false;
        } catch (NonUniqueResultException) {
            return true;
        }

        return true;
    }
}
