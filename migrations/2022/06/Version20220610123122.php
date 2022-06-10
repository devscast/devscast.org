<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20220610123122.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20220610123122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add pronouns';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD pronouns VARCHAR(10) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('ALTER TABLE user DROP pronouns');
    }
}
