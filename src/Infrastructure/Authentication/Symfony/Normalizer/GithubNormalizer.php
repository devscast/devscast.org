<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Normalizer;

use Infrastructure\Shared\Symfony\Normalizer\AbstractNormalizer;

/**
 * Class GithubNormalizer
 * @package Infrastructure\Authentication\Symfony\Normalizer
 * @author bernard-ng <bernard@devscast.tech>
 */
final class GithubNormalizer extends AbstractNormalizer
{
    /**
     * @param GithubResourceOwner $object
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'email' => $object->getEmail(),
            'github_id' => strval($object->getId()),
            'type' => 'Github',
            'username' => $object->getNickname(),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof GithubResourceOwner;
    }
}
