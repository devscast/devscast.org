<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Normalizer;

use Infrastructure\Shared\Symfony\Normalizer\AbstractNormalizer;
use League\OAuth2\Client\Provider\FacebookUser;

/**
 * Class FacebookNormalizer.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class FacebookNormalizer extends AbstractNormalizer
{
    /**
     * @param FacebookUser $object
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'email' => $object->getEmail(),
            'facebook_id' => strval($object->getId()),
            'type' => 'Facebook',
            'username' => $object->getName(),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof FacebookUser;
    }
}
