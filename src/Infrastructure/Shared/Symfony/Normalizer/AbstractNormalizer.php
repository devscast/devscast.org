<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class Normalizer
 * @package Infrastructure\Shared\Symfony\Normalizer
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    abstract public function normalize($object, string $format = null, array $context = []): array;

    abstract public function supportsNormalization($data, string $format = null): bool;

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
