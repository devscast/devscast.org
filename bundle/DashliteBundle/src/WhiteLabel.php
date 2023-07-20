<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle;

/**
 * Class DashliteConfig.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class WhiteLabel
{
    public readonly array $application;

    public function __construct(array $config = [])
    {
        $this->application = $config['application'] ?? throw new \InvalidArgumentException('Missing application configuration');
    }

    public static function create(array $config = []): self
    {
        return new self($config);
    }
}
