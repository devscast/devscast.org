<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Doctrine;

use BadMethodCallException;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Selectable;
use Doctrine\DBAL\LockMode;
use Doctrine\Deprecations\Deprecation;
use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\LazyCriteriaCollection;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use Doctrine\Persistence\ObjectRepository;

use function array_slice;
use function lcfirst;
use function sprintf;
use function strpos;
use function substr;

/**
 * An EntityRepository serves as a repository for entities with generic as well as
 * business specific methods for retrieving entities.
 *
 * This class is designed for inheritance and users can subclass this class to
 * write their own repositories with business-specific methods to locate entities.
 *
 * @template T
 * @template-implements Selectable<int,T>
 * @template-implements ObjectRepository<T>
 */
class EntityRepository implements ObjectRepository, Selectable
{
    protected string $_entityName;

    protected EntityManagerInterface $_em;

    protected ClassMetadata $_class;

    private static Inflector $inflector;

    /**
     * Initializes a new <tt>EntityRepository</tt>.
     */
    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        $this->_entityName = $class->name;
        $this->_em = $em;
        $this->_class = $class;
    }

    public function createQueryBuilder(string $alias, string $indexBy = null): QueryBuilder
    {
        return $this->_em->createQueryBuilder()
            ->select($alias)
            ->from($this->_entityName, $alias, $indexBy);
    }

    public function createResultSetMappingBuilder(string $alias): ResultSetMappingBuilder
    {
        $rsm = new ResultSetMappingBuilder($this->_em, ResultSetMappingBuilder::COLUMN_RENAMING_INCREMENT);
        $rsm->addRootEntityFromClassMetadata($this->_entityName, $alias);
        return $rsm;
    }

    /**
     * Finds an entity by its primary key / identifier.
     * @psalm-return ?T
     */
    public function find(mixed $id, ?int $lockMode = null, ?int $lockVersion = null): ?object
    {
        return $this->_em->find($this->_entityName, $id, $lockMode, $lockVersion);
    }

    /**
     * Finds all entities in the repository.
     * @psalm-return list<T> The entities.
     */
    public function findAll(): array
    {
        return $this->findBy([]);
    }

    /**
     * Finds entities by a set of criteria.
     * @psalm-return list<T>
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);
        return $persister->loadAll($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Finds a single entity by a set of criteria.
     * @psalm-return ?T
     */
    public function findOneBy(array $criteria, ?array $orderBy = null): ?object
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);
        return $persister->load($criteria, null, null, [], null, 1, $orderBy);
    }

    /**
     * Counts entities by a set of criteria.
     * @psalm-param array<string, mixed> $criteria
     */
    public function count(array $criteria): int
    {
        return $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName)->count($criteria);
    }

    /**
     * Adds support for magic method calls.
     *
     * @param string $method
     * @param array $arguments
     * @psalm-param list<mixed> $arguments
     *
     * @return mixed The returned value from the resolved method.
     *
     * @throws BadMethodCallException|InvalidMagicMethodCall If the method called is invalid.
     */
    public function __call(string $method, array $arguments): mixed
    {
        if (str_starts_with($method, 'findBy')) {
            return $this->resolveMagicCall('findBy', substr($method, 6), $arguments);
        }

        if (str_starts_with($method, 'findOneBy')) {
            return $this->resolveMagicCall('findOneBy', substr($method, 9), $arguments);
        }

        if (str_starts_with($method, 'countBy')) {
            return $this->resolveMagicCall('count', substr($method, 7), $arguments);
        }

        throw new BadMethodCallException(sprintf(
            'Undefined method "%s". The method name must start with ' .
            'either findBy, findOneBy or countBy!',
            $method
        ));
    }

    protected function getEntityName(): string
    {
        return $this->_entityName;
    }

    public function getClassName(): string
    {
        return $this->_entityName;
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->_em;
    }

    protected function getClassMetadata(): ClassMetadata
    {
        return $this->_class;
    }

    /**
     * Select all elements from a selectable that match the expression and
     * return a new collection containing these elements.
     * @psalm-return Collection<int, T>
     */
    public function matching(Criteria $criteria): LazyCriteriaCollection
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);
        return new LazyCriteriaCollection($persister, $criteria);
    }

    /**
     * Resolves a magic method call to the proper existent method at `EntityRepository`.
     *
     * @param string $method The method to call
     * @param string $by The property name used as condition
     * @param array $arguments
     * @return mixed
     *
     * @throws InvalidMagicMethodCall If the method called is invalid or the
     *                                requested field/association does not exist.
     * @psalm-param list<mixed> $arguments The arguments to pass at method call
     *
     */
    private function resolveMagicCall(string $method, string $by, array $arguments): mixed
    {
        if (!$arguments) {
            throw InvalidMagicMethodCall::onMissingParameter($method . $by);
        }

        if (self::$inflector === null) {
            self::$inflector = InflectorFactory::create()->build();
        }

        $fieldName = lcfirst(self::$inflector->classify($by));

        if (!($this->_class->hasField($fieldName) || $this->_class->hasAssociation($fieldName))) {
            throw InvalidMagicMethodCall::becauseFieldNotFoundIn(
                $this->_entityName,
                $fieldName,
                $method . $by
            );
        }

        return $this->$method([$fieldName => $arguments[0]], ...array_slice($arguments, 1));
    }
}
