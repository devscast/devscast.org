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
    private array $backup_codes = [];

    public function isBackupCode(string $code): bool
    {
        return in_array($code, $this->backup_codes, true);
    }

    public function setBackupCode(array $codes): self
    {
        if (6 !== count($codes)) {
            throw new \InvalidArgumentException('Please set 6 backup codes with 6 digits long');
        }
        $this->backup_codes = $codes;

        return $this;
    }

    public function getBackupCode(): array
    {
        return $this->backup_codes;
    }

    public function invalidateBackupCode(string $code): void
    {
        $this->backup_codes = array_splice(
            array: $this->backup_codes,
            offset: (int) array_search($code, $this->backup_codes, true),
            length: 1
        );
    }
}
