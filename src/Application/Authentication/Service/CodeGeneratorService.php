<?php

declare(strict_types=1);

namespace Application\Authentication\Service;

/**
 * class DefaultPasswordGeneratorService.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CodeGeneratorService
{
    public function generate(int $length = 6): int
    {
        return random_int(10 ** ($length - 1), 10 ** $length - 1);
    }

    public function generateToken(int $length = 60): string
    {
        return substr(bin2hex(random_bytes(max(1, (int) ceil($length / 2)))), 0, $length);
    }
}
