<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20220922083227.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20220922083227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add user links';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD linkedin_url VARCHAR(255) DEFAULT NULL, ADD twitter_url VARCHAR(255) DEFAULT NULL, ADD github_url VARCHAR(255) DEFAULT NULL, ADD website_url VARCHAR(255) DEFAULT NULL, ADD rss_url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP linkedin_url, DROP twitter_url, DROP github_url, DROP website_url, DROP rss_url');
    }
}
