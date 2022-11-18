<?php

declare(strict_types=1);

namespace Domain\Shared\Entity;

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
