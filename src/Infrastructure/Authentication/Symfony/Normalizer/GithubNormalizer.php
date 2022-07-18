<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Normalizer;

use Infrastructure\Shared\Symfony\Normalizer\AbstractNormalizer;
use League\OAuth2\Client\Provider\GithubResourceOwner;

/**
 * Class GithubNormalizer.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class GithubNormalizer extends AbstractNormalizer
{
    /**
     * @param GithubResourceOwner $object
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        return [
            'email' => $object->getEmail(),
            'github_id' => strval($object->getId()),
            'type' => 'Github',
            'username' => $object->getNickname(),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof GithubResourceOwner;
    }
}
