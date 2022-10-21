<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20221021044826.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20221021044826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'attachement';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE content_attachment (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', thumbnail_name VARCHAR(255) DEFAULT NULL, thumbnail_original_name VARCHAR(255) DEFAULT NULL, thumbnail_mime_type VARCHAR(255) DEFAULT NULL, thumbnail_size INT DEFAULT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_E0666F497E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content_attachment ADD CONSTRAINT FK_E0666F497E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\'), CHANGE education_level education_level ENUM(\'beginner\', \'intermediate\', \'advanced\')');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status ENUM(\'reviewing\', \'rejected\', \'accepted\')');
        $this->addSql('ALTER TABLE podcast_episode CHANGE episode_type episode_type ENUM(\'Full\', \'Bonus\', \'Trailer\')');
        $this->addSql('ALTER TABLE post_series CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\')');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F463524D5E237E06 ON technology (name)');
        $this->addSql('ALTER TABLE user CHANGE gender gender ENUM(\'M\', \'F\', \'O\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE content_attachment');
        $this->addSql('ALTER TABLE content CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE education_level education_level VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE podcast_episode CHANGE episode_type episode_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE post_series CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_F463524D5E237E06 ON technology');
        $this->addSql('ALTER TABLE user CHANGE gender gender VARCHAR(255) DEFAULT NULL');
    }
}
