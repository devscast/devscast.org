<?php

declare(strict_types=1);

namespace Application\Shared\DataTransfert;

use Infrastructure\Shared\Symfony\Form\AbstractForm;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Class AbstractCrudData.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractCrudData implements CrudDataInterface
{
    public function __construct(
        protected object $entity
    ) {
        $reflexion = new \ReflectionClass($this);
        $properties = $reflexion->getProperties(\ReflectionProperty::IS_PUBLIC);
        $accessor = new PropertyAccessor();

        foreach ($properties as $property) {
            $name = $property->getName();

            /** @var \ReflectionNamedType|\ReflectionUnionType|null $type */
            $type = $property->getType();

            if ($type instanceof \ReflectionNamedType && UploadedFile::class === $type->getName()) {
                continue;
            }

            $accessor->setValue($this, $name, $accessor->getValue($this->entity, $name));
        }
    }

    public function hydrate(): CrudDataInterface
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        $accessor = new PropertyAccessor();

        foreach ($properties as $property) {
            $name = $property->getName();
            $value = $accessor->getValue($this, $name);
            $accessor->setValue($this->entity, $name, $value);
        }

        return $this;
    }

    public function getId(): ?int
    {
        if (method_exists($this->entity, 'getId')) {
            return $this->entity->getId();
        }
        throw new \RuntimeException('The entity object must have a getId() method');
    }

    public function getEntity(): object
    {
        return $this->entity;
    }

    public function setEntity(object $entity): CrudDataInterface
    {
        $this->entity = $entity;

        return $this;
    }

    public function getFormClass(): string
    {
        return AbstractForm::class;
    }
}
