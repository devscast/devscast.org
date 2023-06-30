<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller;

enum CrudAction: string
{
    case CREATE = 'write';
    case READ = 'read';
    case UPDATE = 'update';
    case DELETE = 'delete';
}
