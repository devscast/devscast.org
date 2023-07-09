<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller;

use Devscast\Bundle\DddBundle\Domain\Entity\HasIdentityInterface;

class CrudParams
{
    public function __construct(
        public readonly CrudAction $action = CrudAction::READ,
        public readonly ?HasIdentityInterface $item = null,
        public readonly ?string $formClass = null,
        public readonly ?string $view = null,
        public readonly ?string $redirectUrl = null,
        public readonly bool $hasIndex = false,
        public readonly bool $hasShow = false,
        public readonly bool $overrideView = false
    ) {
    }
}
