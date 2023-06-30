<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Devscast\Bundle\DddBundle\Domain\Entity\AbstractEntity;
use Domain\Authentication\Entity\User;
use Domain\Shared\Entity\OwnerTrait;

/**
 * class ContentView.
 * used to track content view and user history.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class ContentView extends AbstractEntity
{
    use OwnerTrait;

    protected Content $target;

    protected string $ip;

    public static function create(Content $target, string $ip, ?User $owner): self
    {
        return (new self())
            ->setTarget($target)
            ->setIp($ip)
            ->setOwner($owner);
    }

    public function getTarget(): Content
    {
        return $this->target;
    }

    public function setTarget(Content $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }
}
