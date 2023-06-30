<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Domain\Entity;

use Symfony\Component\Uid\Uuid;

/**
 * interface HasIdentityInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface HasIdentityInterface
{
    public function getId(): ?Uuid;
}
