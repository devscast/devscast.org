<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20230107031200.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20230107031200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add content_view and content vieww count';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE content_view (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, target_id INT NOT NULL, ip VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_339F464B7E3C61F9 (owner_id), INDEX IDX_339F464B158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content_view ADD CONSTRAINT FK_339F464B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_view ADD CONSTRAINT FK_339F464B158E0B66 FOREIGN KEY (target_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content ADD unique_view_count INT DEFAULT 0 NOT NULL, ADD view_count INT DEFAULT 0 NOT NULL, CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\'), CHANGE education_level education_level ENUM(\'beginner\', \'intermediate\', \'advanced\')');
        $this->addSql('ALTER TABLE content_podcast_episode CHANGE episode_type episode_type ENUM(\'Full\', \'Bonus\', \'Trailer\')');
        $this->addSql('ALTER TABLE content_post_series CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\')');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status ENUM(\'reviewing\', \'rejected\', \'accepted\')');
        $this->addSql('ALTER TABLE user CHANGE gender gender ENUM(\'M\', \'F\', \'O\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE content_view');
        $this->addSql('ALTER TABLE content DROP unique_view_count, DROP view_count, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE education_level education_level VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_podcast_episode CHANGE episode_type episode_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_post_series CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE gender gender VARCHAR(255) DEFAULT NULL');
    }
}
