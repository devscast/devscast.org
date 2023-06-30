<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Twig\Cache;

use Symfony\Component\Uid\Uuid;

/**
 * interface CacheableInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface CacheableInterface
{
    public function getUpdatedAt(): ?\DateTimeInterface;

    public function getId(): ?Uuid;
}
