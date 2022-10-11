<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20221011145747.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20221011145747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'using embedded file value object';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE content ADD thumbnail_name VARCHAR(255) DEFAULT NULL, ADD thumbnail_original_name VARCHAR(255) DEFAULT NULL, ADD thumbnail_mime_type VARCHAR(255) DEFAULT NULL, DROP thumbnail_url, DROP thumbnail_type, CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\'), CHANGE thumbnail_size thumbnail_size INT DEFAULT NULL, CHANGE thumbnail_dimensions thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE education_level education_level ENUM(\'beginner\', \'intermediate\', \'advanced\')');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status ENUM(\'reviewing\', \'rejected\', \'accepted\')');
        $this->addSql('ALTER TABLE podcast_episode ADD audio_name VARCHAR(255) DEFAULT NULL, ADD audio_original_name VARCHAR(255) DEFAULT NULL, ADD audio_mime_type VARCHAR(255) DEFAULT NULL, ADD audio_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', DROP audio_url, DROP audio_type, CHANGE episode_type episode_type ENUM(\'Full\', \'Bonus\', \'Trailer\'), CHANGE audio_size audio_size INT DEFAULT NULL');
        $this->addSql('ALTER TABLE podcast_season ADD thumbnail_name VARCHAR(255) DEFAULT NULL, ADD thumbnail_original_name VARCHAR(255) DEFAULT NULL, ADD thumbnail_mime_type VARCHAR(255) DEFAULT NULL, DROP thumbnail_url, DROP thumbnail_type, CHANGE thumbnail_size thumbnail_size INT DEFAULT NULL, CHANGE thumbnail_dimensions thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE user ADD avatar_name VARCHAR(255) DEFAULT NULL, ADD avatar_original_name VARCHAR(255) DEFAULT NULL, ADD avatar_mime_type VARCHAR(255) DEFAULT NULL, ADD avatar_size INT DEFAULT NULL, ADD avatar_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE gender gender ENUM(\'M\', \'F\', \'O\'), CHANGE rss_url rss_url VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE content ADD thumbnail_url VARCHAR(255) NOT NULL, ADD thumbnail_type VARCHAR(255) NOT NULL, DROP thumbnail_name, DROP thumbnail_original_name, DROP thumbnail_mime_type, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE thumbnail_size thumbnail_size INT NOT NULL, CHANGE thumbnail_dimensions thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE education_level education_level VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE podcast_episode ADD audio_url VARCHAR(255) NOT NULL, ADD audio_type VARCHAR(255) DEFAULT \'audio/mp3\' NOT NULL, DROP audio_name, DROP audio_original_name, DROP audio_mime_type, DROP audio_dimensions, CHANGE episode_type episode_type VARCHAR(255) DEFAULT NULL, CHANGE audio_size audio_size INT NOT NULL');
        $this->addSql('ALTER TABLE podcast_season ADD thumbnail_url VARCHAR(255) NOT NULL, ADD thumbnail_type VARCHAR(255) NOT NULL, DROP thumbnail_name, DROP thumbnail_original_name, DROP thumbnail_mime_type, CHANGE thumbnail_size thumbnail_size INT NOT NULL, CHANGE thumbnail_dimensions thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE user DROP avatar_name, DROP avatar_original_name, DROP avatar_mime_type, DROP avatar_size, DROP avatar_dimensions, CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE rss_url rss_url VARCHAR(255) DEFAULT NULL');
    }
}
