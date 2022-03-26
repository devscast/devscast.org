<?php

declare(strict_types=1);

namespace Application\Shared\DataTransfert;

/**
 * Interface CrudDataInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface CrudDataInterface
{
    public function getId(): ?int;

    public function getEntity(): object;

    public function setEntity(object $entity): self;

    public function getFormClass(): string;

    /**
     * Transfert les données du DTO vers l'entity, ceci permet
     * de modifier l'entity seulement en passant par un DTO, ce qui garantie
     * une certaine securité vu que les DTOs sont validés (validation applicative) au préalable.
     *
     * @return $this
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function hydrate(): self;
}
