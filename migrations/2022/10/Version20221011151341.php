<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011151341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\'), CHANGE education_level education_level ENUM(\'beginner\', \'intermediate\', \'advanced\')');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status ENUM(\'reviewing\', \'rejected\', \'accepted\')');
        $this->addSql('ALTER TABLE podcast_episode CHANGE episode_type episode_type ENUM(\'Full\', \'Bonus\', \'Trailer\')');
        $this->addSql('ALTER TABLE user CHANGE gender gender ENUM(\'M\', \'F\', \'O\'), CHANGE rss_url rss_url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE education_level education_level VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE podcast_episode CHANGE episode_type episode_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE rss_url rss_url VARCHAR(255) NOT NULL');
    }
}
