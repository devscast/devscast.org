<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20221016191323.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20221016191323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'authentication && content';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE content (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(300) NOT NULL, content LONGTEXT NOT NULL, duration INT DEFAULT NULL, is_commentable TINYINT(1) DEFAULT 0 NOT NULL, is_featured TINYINT(1) DEFAULT 0 NOT NULL, is_top_promoted TINYINT(1) DEFAULT 0 NOT NULL, is_online TINYINT(1) DEFAULT 0 NOT NULL, is_premium TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\'), thumbnail_name VARCHAR(255) DEFAULT NULL, thumbnail_original_name VARCHAR(255) DEFAULT NULL, thumbnail_mime_type VARCHAR(255) DEFAULT NULL, thumbnail_size INT DEFAULT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', education_level ENUM(\'beginner\', \'intermediate\', \'advanced\'), content_type VARCHAR(255) NOT NULL, INDEX IDX_FEC530A97E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_assigned_tag (content_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_1C5E773A84A0A3ED (content_id), INDEX IDX_1C5E773ABAD26311 (tag_id), PRIMARY KEY(content_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_assigned_technology (content_id INT NOT NULL, technology_id INT NOT NULL, INDEX IDX_63C9A20A84A0A3ED (content_id), INDEX IDX_63C9A20A4235D463 (technology_id), PRIMARY KEY(content_id, technology_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_comment (id INT AUTO_INCREMENT NOT NULL, target_id INT NOT NULL, owner_id INT NOT NULL, parent_id INT DEFAULT NULL, content VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4B7C8BDF158E0B66 (target_id), INDEX IDX_4B7C8BDF7E3C61F9 (owner_id), INDEX IDX_4B7C8BDF727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_rating (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, target_id INT NOT NULL, rating SMALLINT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B0BF568E7E3C61F9 (owner_id), INDEX IDX_B0BF568E158E0B66 (target_id), UNIQUE INDEX UNIQ_B0BF568E158E0B667E3C61F9 (target_id, owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_subject_proposal (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, subject VARCHAR(255) NOT NULL, votes_count INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status ENUM(\'reviewing\', \'rejected\', \'accepted\'), INDEX IDX_3FA4A5E87E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_subject_proposal_vote (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, proposal_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E38B4FD67E3C61F9 (owner_id), INDEX IDX_E38B4FD6F4792058 (proposal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE login_attempt (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8C11C1B7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE podcast_episode (id INT NOT NULL, season_id INT DEFAULT NULL, episode_type ENUM(\'Full\', \'Bonus\', \'Trailer\'), audio_name VARCHAR(255) DEFAULT NULL, audio_original_name VARCHAR(255) DEFAULT NULL, audio_mime_type VARCHAR(255) DEFAULT NULL, audio_size INT DEFAULT NULL, audio_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_77EB2BD04EC001D1 (season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE podcast_season (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, short_code VARCHAR(255) DEFAULT \'S1\' NOT NULL, description LONGTEXT NOT NULL, episode_count INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', thumbnail_name VARCHAR(255) DEFAULT NULL, thumbnail_original_name VARCHAR(255) DEFAULT NULL, thumbnail_mime_type VARCHAR(255) DEFAULT NULL, thumbnail_size INT DEFAULT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT NOT NULL, category_id INT DEFAULT NULL, series_id INT DEFAULT NULL, INDEX IDX_5A8A6C8D12469DE2 (category_id), INDEX IDX_5A8A6C8D5278319C (series_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, post_count INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_list (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_public TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8D9D9F137E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_list_assigned_post (post_list_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_7B69627F46A1B8 (post_list_id), INDEX IDX_7B69627F4B89032C (post_id), PRIMARY KEY(post_list_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_series (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, technology_id INT DEFAULT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(300) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\'), thumbnail_name VARCHAR(255) DEFAULT NULL, thumbnail_original_name VARCHAR(255) DEFAULT NULL, thumbnail_mime_type VARCHAR(255) DEFAULT NULL, thumbnail_size INT DEFAULT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_A32E5487E3C61F9 (owner_id), INDEX IDX_A32E5484235D463 (technology_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_token (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_452C9EC57E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technology (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', thumbnail_name VARCHAR(255) DEFAULT NULL, thumbnail_original_name VARCHAR(255) DEFAULT NULL, thumbnail_mime_type VARCHAR(255) DEFAULT NULL, thumbnail_size INT DEFAULT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) DEFAULT NULL, pronouns VARCHAR(10) DEFAULT NULL, job_title VARCHAR(150) DEFAULT NULL, biography LONGTEXT DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, phone_number VARCHAR(15) DEFAULT NULL, country VARCHAR(3) DEFAULT \'CD\', password VARCHAR(4096) DEFAULT NULL, is_subscribed_newsletter TINYINT(1) DEFAULT 0 NOT NULL, is_subscribed_marketing TINYINT(1) DEFAULT 0 NOT NULL, is_dark_theme TINYINT(1) DEFAULT 1 NOT NULL, linkedin_url VARCHAR(255) DEFAULT NULL, twitter_url VARCHAR(255) DEFAULT NULL, github_url VARCHAR(255) DEFAULT NULL, website_url VARCHAR(255) DEFAULT NULL, reset_login_attempts_token VARCHAR(255) DEFAULT NULL, email_verification_token VARCHAR(255) DEFAULT NULL, is_email_verified TINYINT(1) DEFAULT 0 NOT NULL, phone_number_verification_token VARCHAR(255) DEFAULT NULL, is_phone_number_verified TINYINT(1) DEFAULT 0 NOT NULL, is_banned TINYINT(1) DEFAULT 0 NOT NULL, banned_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_login_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_login_ip VARCHAR(255) DEFAULT NULL, github_id VARCHAR(255) DEFAULT NULL, facebook_id VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, is_email_auth_enabled TINYINT(1) DEFAULT 0 NOT NULL, email_auth_code VARCHAR(6) DEFAULT NULL, is_google_auth_enabled TINYINT(1) DEFAULT 0 NOT NULL, google_auth_secret VARCHAR(255) DEFAULT NULL, backup_codes LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', username VARCHAR(30) NOT NULL, gender ENUM(\'M\', \'F\', \'O\'), roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', rss_url VARCHAR(255) DEFAULT NULL, avatar_name VARCHAR(255) DEFAULT NULL, avatar_original_name VARCHAR(255) DEFAULT NULL, avatar_mime_type VARCHAR(255) DEFAULT NULL, avatar_size INT DEFAULT NULL, avatar_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', UNIQUE INDEX UNIQ_8D93D6496B01BC5B (phone_number), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT NOT NULL, source_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A97E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_assigned_tag ADD CONSTRAINT FK_1C5E773A84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE content_assigned_tag ADD CONSTRAINT FK_1C5E773ABAD26311 FOREIGN KEY (tag_id) REFERENCES content_tag (id)');
        $this->addSql('ALTER TABLE content_assigned_technology ADD CONSTRAINT FK_63C9A20A84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE content_assigned_technology ADD CONSTRAINT FK_63C9A20A4235D463 FOREIGN KEY (technology_id) REFERENCES technology (id)');
        $this->addSql('ALTER TABLE content_comment ADD CONSTRAINT FK_4B7C8BDF158E0B66 FOREIGN KEY (target_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_comment ADD CONSTRAINT FK_4B7C8BDF7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_comment ADD CONSTRAINT FK_4B7C8BDF727ACA70 FOREIGN KEY (parent_id) REFERENCES content_comment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_rating ADD CONSTRAINT FK_B0BF568E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_rating ADD CONSTRAINT FK_B0BF568E158E0B66 FOREIGN KEY (target_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_subject_proposal ADD CONSTRAINT FK_3FA4A5E87E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_subject_proposal_vote ADD CONSTRAINT FK_E38B4FD67E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_subject_proposal_vote ADD CONSTRAINT FK_E38B4FD6F4792058 FOREIGN KEY (proposal_id) REFERENCES content_subject_proposal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE login_attempt ADD CONSTRAINT FK_8C11C1B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE podcast_episode ADD CONSTRAINT FK_77EB2BD04EC001D1 FOREIGN KEY (season_id) REFERENCES podcast_season (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE podcast_episode ADD CONSTRAINT FK_77EB2BD0BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D12469DE2 FOREIGN KEY (category_id) REFERENCES post_category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D5278319C FOREIGN KEY (series_id) REFERENCES post_series (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DBF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_list ADD CONSTRAINT FK_8D9D9F137E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_list_assigned_post ADD CONSTRAINT FK_7B69627F46A1B8 FOREIGN KEY (post_list_id) REFERENCES post_list (id)');
        $this->addSql('ALTER TABLE post_list_assigned_post ADD CONSTRAINT FK_7B69627F4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post_series ADD CONSTRAINT FK_A32E5487E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_series ADD CONSTRAINT FK_A32E5484235D463 FOREIGN KEY (technology_id) REFERENCES technology (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE reset_password_token ADD CONSTRAINT FK_452C9EC57E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CBF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE content_assigned_tag DROP FOREIGN KEY FK_1C5E773A84A0A3ED');
        $this->addSql('ALTER TABLE content_assigned_technology DROP FOREIGN KEY FK_63C9A20A84A0A3ED');
        $this->addSql('ALTER TABLE content_comment DROP FOREIGN KEY FK_4B7C8BDF158E0B66');
        $this->addSql('ALTER TABLE content_rating DROP FOREIGN KEY FK_B0BF568E158E0B66');
        $this->addSql('ALTER TABLE podcast_episode DROP FOREIGN KEY FK_77EB2BD0BF396750');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DBF396750');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CBF396750');
        $this->addSql('ALTER TABLE content_comment DROP FOREIGN KEY FK_4B7C8BDF727ACA70');
        $this->addSql('ALTER TABLE content_subject_proposal_vote DROP FOREIGN KEY FK_E38B4FD6F4792058');
        $this->addSql('ALTER TABLE content_assigned_tag DROP FOREIGN KEY FK_1C5E773ABAD26311');
        $this->addSql('ALTER TABLE podcast_episode DROP FOREIGN KEY FK_77EB2BD04EC001D1');
        $this->addSql('ALTER TABLE post_list_assigned_post DROP FOREIGN KEY FK_7B69627F4B89032C');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D12469DE2');
        $this->addSql('ALTER TABLE post_list_assigned_post DROP FOREIGN KEY FK_7B69627F46A1B8');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D5278319C');
        $this->addSql('ALTER TABLE content_assigned_technology DROP FOREIGN KEY FK_63C9A20A4235D463');
        $this->addSql('ALTER TABLE post_series DROP FOREIGN KEY FK_A32E5484235D463');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A97E3C61F9');
        $this->addSql('ALTER TABLE content_comment DROP FOREIGN KEY FK_4B7C8BDF7E3C61F9');
        $this->addSql('ALTER TABLE content_rating DROP FOREIGN KEY FK_B0BF568E7E3C61F9');
        $this->addSql('ALTER TABLE content_subject_proposal DROP FOREIGN KEY FK_3FA4A5E87E3C61F9');
        $this->addSql('ALTER TABLE content_subject_proposal_vote DROP FOREIGN KEY FK_E38B4FD67E3C61F9');
        $this->addSql('ALTER TABLE login_attempt DROP FOREIGN KEY FK_8C11C1B7E3C61F9');
        $this->addSql('ALTER TABLE post_list DROP FOREIGN KEY FK_8D9D9F137E3C61F9');
        $this->addSql('ALTER TABLE post_series DROP FOREIGN KEY FK_A32E5487E3C61F9');
        $this->addSql('ALTER TABLE reset_password_token DROP FOREIGN KEY FK_452C9EC57E3C61F9');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE content_assigned_tag');
        $this->addSql('DROP TABLE content_assigned_technology');
        $this->addSql('DROP TABLE content_comment');
        $this->addSql('DROP TABLE content_rating');
        $this->addSql('DROP TABLE content_subject_proposal');
        $this->addSql('DROP TABLE content_subject_proposal_vote');
        $this->addSql('DROP TABLE content_tag');
        $this->addSql('DROP TABLE login_attempt');
        $this->addSql('DROP TABLE podcast_episode');
        $this->addSql('DROP TABLE podcast_season');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_category');
        $this->addSql('DROP TABLE post_list');
        $this->addSql('DROP TABLE post_list_assigned_post');
        $this->addSql('DROP TABLE post_series');
        $this->addSql('DROP TABLE reset_password_token');
        $this->addSql('DROP TABLE technology');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
    }
}
