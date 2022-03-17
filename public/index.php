<?php

declare(strict_types=1);

use Infrastructure\Shared\Symfony\Kernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel(
        environment: $context['APP_ENV'],
        debug: (bool)$context['APP_DEBUG']
    );
};
