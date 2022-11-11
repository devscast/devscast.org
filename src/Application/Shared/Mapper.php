<?php

declare(strict_types=1);

namespace Application\Shared;

use Symfony\Component\PropertyAccess\PropertyAccess;

final class Mapper
{
    public static function hydrate(object $source, object $destination, array $ignore = []): void
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->getPropertyAccessor();
        $sourceReflection = new \ReflectionClass($source);
        $destinationReflection = new \ReflectionClass($destination);

        foreach ($sourceReflection->getProperties() as $property) {
            $propertyName = $property->getName();
            if ($destinationReflection->hasProperty($propertyName) && ! in_array($propertyName, $ignore, true)) {
                $propertyAccessor->setValue($destination, $propertyName, $property->getValue($source));
            }
        }
    }

    public static function getHydratedObject(object $source, object $destination, array $ignore = []): object
    {
        self::hydrate($source, $destination, $ignore);

        return $destination;
    }

    public static function hasProperties(object $source, array $properties): bool
    {
        foreach ($properties as $property) {
            if (! property_exists($source, $property)) {
                return false;
            }
        }

        return true;
    }
}
