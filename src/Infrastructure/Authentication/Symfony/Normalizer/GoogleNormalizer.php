<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Normalizer;

use Infrastructure\Shared\Symfony\Normalizer\AbstractNormalizer;
use League\OAuth2\Client\Provider\GoogleUser;

/**
 * Class GoogleNormalizer.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class GoogleNormalizer extends AbstractNormalizer
{
    /**
     * @param GoogleUser $object
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'email' => $object->getEmail(),
            'google_id' => strval($object->getId()),
            'type' => 'Google',
            'username' => $object->getName(),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof GoogleUser;
    }
}
