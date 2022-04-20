<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

/**
 * Trait BackupAuthTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait BackupAuthTrait
{
    private ?array $backup_codes = [];

    public function isBackupCode(string $code): bool
    {
        return in_array((int) $code, $this->getBackupCode(), true);
    }

    public function setBackupCode(?array $codes = []): self
    {
        if (null === $codes) {
            $this->backup_codes = [];
        } elseif (6 !== count($codes)) {
            throw new \InvalidArgumentException('Please set 6 backup codes with 6 digits long');
        } else {
            $this->backup_codes = $codes;
        }

        return $this;
    }

    public function getBackupCode(): array
    {
        return $this->backup_codes ?? [];
    }

    public function invalidateBackupCode(string $code): void
    {
        $backup_code = $this->getBackupCode();
        $this->backup_codes = array_filter($this->getBackupCode(), function (string $c) use ($code) {
            return $c !== $code;
        });
    }
}
