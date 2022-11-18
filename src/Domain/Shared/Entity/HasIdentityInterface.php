<?php

declare(strict_types=1);

namespace Domain\Shared\Entity;

/**
 * interface HasIdentityInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface HasIdentityInterface
{
    public function getId(): ?int;
}
