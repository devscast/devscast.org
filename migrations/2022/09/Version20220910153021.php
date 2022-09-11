<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20220910153021.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20220910153021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'reset login attempts token';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD reset_login_attempts_token VARCHAR(355) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP reset_login_attempts_token');
    }
}
