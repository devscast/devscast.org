<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20221029142346.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20221029142346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add episode number';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE content CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\'), CHANGE education_level education_level ENUM(\'beginner\', \'intermediate\', \'advanced\')');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status ENUM(\'reviewing\', \'rejected\', \'accepted\')');
        $this->addSql('ALTER TABLE podcast_episode ADD episode_number INT NOT NULL, CHANGE episode_type episode_type ENUM(\'Full\', \'Bonus\', \'Trailer\')');
        $this->addSql('ALTER TABLE post_series CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\')');
        $this->addSql('ALTER TABLE user CHANGE gender gender ENUM(\'M\', \'F\', \'O\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE content CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE education_level education_level VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE podcast_episode DROP episode_number, CHANGE episode_type episode_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE post_series CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE gender gender VARCHAR(255) DEFAULT NULL');
    }
}
