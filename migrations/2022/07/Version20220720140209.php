<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220720140209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE content (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(300) NOT NULL, content LONGTEXT NOT NULL, duration INT DEFAULT NULL, is_commentable TINYINT(1) DEFAULT 0 NOT NULL, is_featured TINYINT(1) DEFAULT 0 NOT NULL, is_top_promoted TINYINT(1) DEFAULT 0 NOT NULL, is_online TINYINT(1) DEFAULT 0 NOT NULL, is_premium TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\'), thumbnail_url VARCHAR(255) NOT NULL, thumbnail_type VARCHAR(255) NOT NULL, thumbnail_size INT NOT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', education_level ENUM(\'beginner\', \'intermediate\', \'advanced\'), content_type VARCHAR(255) NOT NULL, INDEX IDX_FEC530A9F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_assigned_tag (content_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_1C5E773A84A0A3ED (content_id), INDEX IDX_1C5E773ABAD26311 (tag_id), PRIMARY KEY(content_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, post_count INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_comment (id INT AUTO_INCREMENT NOT NULL, target_id INT NOT NULL, author_id INT NOT NULL, parent_id INT DEFAULT NULL, content VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4B7C8BDF158E0B66 (target_id), INDEX IDX_4B7C8BDFF675F31B (author_id), INDEX IDX_4B7C8BDF727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE podcast_episode (id INT NOT NULL, season_id INT DEFAULT NULL, episode_type ENUM(\'Full\', \'Bonus\', \'Trailer\'), audio_url VARCHAR(255) NOT NULL, audio_type VARCHAR(255) DEFAULT \'audio/mp3\' NOT NULL, audio_size INT NOT NULL, INDEX IDX_77EB2BD04EC001D1 (season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE podcast_season (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, short_code VARCHAR(255) DEFAULT \'S1\' NOT NULL, description LONGTEXT NOT NULL, episode_count INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', thumbnail_url VARCHAR(255) NOT NULL, thumbnail_type VARCHAR(255) NOT NULL, thumbnail_size INT NOT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT NOT NULL, category_id INT DEFAULT NULL, INDEX IDX_5A8A6C8D12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT NOT NULL, source_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9F675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_assigned_tag ADD CONSTRAINT FK_1C5E773A84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE content_assigned_tag ADD CONSTRAINT FK_1C5E773ABAD26311 FOREIGN KEY (tag_id) REFERENCES content_tag (id)');
        $this->addSql('ALTER TABLE content_comment ADD CONSTRAINT FK_4B7C8BDF158E0B66 FOREIGN KEY (target_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_comment ADD CONSTRAINT FK_4B7C8BDFF675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_comment ADD CONSTRAINT FK_4B7C8BDF727ACA70 FOREIGN KEY (parent_id) REFERENCES content_comment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE podcast_episode ADD CONSTRAINT FK_77EB2BD04EC001D1 FOREIGN KEY (season_id) REFERENCES podcast_season (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE podcast_episode ADD CONSTRAINT FK_77EB2BD0BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D12469DE2 FOREIGN KEY (category_id) REFERENCES content_category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DBF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CBF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE gender gender ENUM(\'M\', \'F\', \'O\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content_assigned_tag DROP FOREIGN KEY FK_1C5E773A84A0A3ED');
        $this->addSql('ALTER TABLE content_comment DROP FOREIGN KEY FK_4B7C8BDF158E0B66');
        $this->addSql('ALTER TABLE podcast_episode DROP FOREIGN KEY FK_77EB2BD0BF396750');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DBF396750');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CBF396750');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D12469DE2');
        $this->addSql('ALTER TABLE content_comment DROP FOREIGN KEY FK_4B7C8BDF727ACA70');
        $this->addSql('ALTER TABLE content_assigned_tag DROP FOREIGN KEY FK_1C5E773ABAD26311');
        $this->addSql('ALTER TABLE podcast_episode DROP FOREIGN KEY FK_77EB2BD04EC001D1');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE content_assigned_tag');
        $this->addSql('DROP TABLE content_category');
        $this->addSql('DROP TABLE content_comment');
        $this->addSql('DROP TABLE content_tag');
        $this->addSql('DROP TABLE podcast_episode');
        $this->addSql('DROP TABLE podcast_season');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE video');
        $this->addSql('ALTER TABLE user CHANGE gender gender VARCHAR(255) DEFAULT NULL');
    }
}
