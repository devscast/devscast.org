<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Construit un formulaire automatiquement en se basant sur les propriétés
 * d'un objet (un DTO dans le cas de figure).
 *
 * Class AbstractForm
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractForm extends AbstractType
{
    protected const TYPES = [
        'string' => TextType::class,
        'bool' => CheckboxType::class,
        'int' => NumberType::class,
        'float' => NumberType::class,
        \DateTimeInterface::class => DateTimeType::class,
        UploadedFile::class => FileType::class,
    ];

    protected const NAMES = [
        'color' => ColorType::class,
    ];

    /**
     * @throws \ReflectionException
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var object $data */
        $data = $options['data'];
        $reflection = new \ReflectionClass($data);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $name = $property->getName();

            /** @var \ReflectionNamedType|\ReflectionUnionType|null $type */
            $type = $property->getType();

            if (null === $type || $type instanceof \ReflectionUnionType) {
                break;
            }

            if (array_key_exists($name, self::NAMES)) {
                $builder->add($name, self::NAMES[$name], [
                    'required' => false,
                ]);
            } elseif (array_key_exists($type->getName(), self::TYPES)) {
                $builder->add($name, self::TYPES[$type->getName()], [
                    'required' => ! $type->allowsNull() && 'bool' !== $type->getName(),
                ]);
            } else {
                throw new \RuntimeException(sprintf('Could not find the field associated with the type %s in %s::%s', $type->getName(), $data::class, $name));
            }
        }
    }
}
