<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Domain\Entity;

/**
 * class AbstractEntity.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractEntity implements HasIdentityInterface
{
    use IdentityTrait;
    use TimestampTrait;
}
