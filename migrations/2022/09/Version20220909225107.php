<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20220909225107.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20220909225107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'user email setting not nullable';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE is_subscribed_newsletter is_subscribed_newsletter TINYINT(1) DEFAULT 0 NOT NULL, CHANGE is_subscribed_marketing is_subscribed_marketing TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE is_subscribed_newsletter is_subscribed_newsletter TINYINT(1) DEFAULT 0, CHANGE is_subscribed_marketing is_subscribed_marketing TINYINT(1) DEFAULT 0');
    }
}
