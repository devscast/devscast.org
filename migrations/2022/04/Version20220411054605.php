<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20220411054605
 * @package DoctrineMigrations
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20220411054605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '2fa backup code support';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD backup_codes LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP backup_codes');
    }
}
