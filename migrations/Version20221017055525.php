<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20221017055525.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20221017055525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'video training and chapters';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE content_progression (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, target_id INT NOT NULL, progress INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8698FAF57E3C61F9 (owner_id), INDEX IDX_8698FAF5158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_training (id INT NOT NULL, youtube_playlist VARCHAR(255) DEFAULT NULL, links VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_training_chapter (id INT AUTO_INCREMENT NOT NULL, training_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, `order` INT DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_89353337BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content_progression ADD CONSTRAINT FK_8698FAF57E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_progression ADD CONSTRAINT FK_8698FAF5158E0B66 FOREIGN KEY (target_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_training ADD CONSTRAINT FK_7D90B833BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_training_chapter ADD CONSTRAINT FK_89353337BEFD98D1 FOREIGN KEY (training_id) REFERENCES video_training (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content ADD up_vote_count INT DEFAULT 0 NOT NULL, ADD down_vote_count INT DEFAULT 0 NOT NULL, ADD ratio_vote_count DOUBLE PRECISION DEFAULT \'0\' NOT NULL, ADD scheduled_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\'), CHANGE education_level education_level ENUM(\'beginner\', \'intermediate\', \'advanced\')');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status ENUM(\'reviewing\', \'rejected\', \'accepted\')');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E38B4FD67E3C61F9F4792058 ON content_subject_proposal_vote (owner_id, proposal_id)');
        $this->addSql('ALTER TABLE podcast_episode CHANGE episode_type episode_type ENUM(\'Full\', \'Bonus\', \'Trailer\')');
        $this->addSql('ALTER TABLE post_series CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\')');
        $this->addSql('ALTER TABLE user CHANGE gender gender ENUM(\'M\', \'F\', \'O\')');
        $this->addSql('ALTER TABLE video ADD training_id INT DEFAULT NULL, ADD timecodes LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CBEFD98D1 FOREIGN KEY (training_id) REFERENCES video_training (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CBEFD98D1 ON video (training_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CBEFD98D1');
        $this->addSql('ALTER TABLE video_training_chapter DROP FOREIGN KEY FK_89353337BEFD98D1');
        $this->addSql('DROP TABLE content_progression');
        $this->addSql('DROP TABLE video_training');
        $this->addSql('DROP TABLE video_training_chapter');
        $this->addSql('ALTER TABLE content DROP up_vote_count, DROP down_vote_count, DROP ratio_vote_count, DROP scheduled_at, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE education_level education_level VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_E38B4FD67E3C61F9F4792058 ON content_subject_proposal_vote');
        $this->addSql('ALTER TABLE podcast_episode CHANGE episode_type episode_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE post_series CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE gender gender VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_7CC7DA2CBEFD98D1 ON video');
        $this->addSql('ALTER TABLE video DROP training_id, DROP timecodes');
    }
}
