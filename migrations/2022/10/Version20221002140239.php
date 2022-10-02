<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20221002140239.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20221002140239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add dark theme';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD is_dark_theme TINYINT(1) DEFAULT 1 NOT NULL, CHANGE reset_login_attempts_token reset_login_attempts_token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP is_dark_theme, CHANGE reset_login_attempts_token reset_login_attempts_token VARCHAR(355) DEFAULT NULL');
    }
}
