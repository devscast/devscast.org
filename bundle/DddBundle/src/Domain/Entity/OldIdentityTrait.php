<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Domain\Entity;

/**
 * trait OldIdentityTrait.
 *
 * pour permettre de reconstruire les relations de l'ancienne
 * base de données en tenant compte des ids assigné par le SGBD
 * lors de la migration vers la nouvelle base de données
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait OldIdentityTrait
{
    private ?int $old_id = null;

    public function getOldId(): ?int
    {
        return $this->old_id;
    }

    public function setOldId(?int $old_id): self
    {
        $this->old_id = $old_id;

        return $this;
    }
}
