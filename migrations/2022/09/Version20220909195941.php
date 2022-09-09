<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20220909195941.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20220909195941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add newsletter and marketing setting';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD is_subscribed_newsletter TINYINT(1) DEFAULT 0, ADD is_subscribed_marketing TINYINT(1) DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP is_subscribed_newsletter, DROP is_subscribed_marketing');
    }
}
