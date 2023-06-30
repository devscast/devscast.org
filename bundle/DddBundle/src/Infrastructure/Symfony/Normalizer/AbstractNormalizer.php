<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Symfony\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * class AbstractNormalizer.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    abstract public function normalize(mixed $object, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null;

    abstract public function supportsNormalization($data, string $format = null, array $context = []): bool;

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
