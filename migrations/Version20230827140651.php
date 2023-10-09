<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20230827140651.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20230827140651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'initial database';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE auth_login_attempt (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', owner_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F52C00B7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auth_reset_password_token (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', owner_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_4C7FBB267E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', owner_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(300) NOT NULL, content LONGTEXT NOT NULL, duration INT DEFAULT NULL, comment_count INT DEFAULT 0 NOT NULL, unique_view_count INT DEFAULT 0 NOT NULL, view_count INT DEFAULT 0 NOT NULL, last_view_milestone_reached INT DEFAULT 0 NOT NULL, status VARCHAR(255) NOT NULL, education_level VARCHAR(255) NOT NULL, is_commentable TINYINT(1) DEFAULT 0 NOT NULL, is_featured TINYINT(1) DEFAULT 0 NOT NULL, is_top_promoted TINYINT(1) DEFAULT 0 NOT NULL, is_online TINYINT(1) DEFAULT 0 NOT NULL, is_premium TINYINT(1) DEFAULT 0 NOT NULL, is_community TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', scheduled_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', thumbnail_name VARCHAR(255) DEFAULT NULL, thumbnail_original_name VARCHAR(255) DEFAULT NULL, thumbnail_mime_type VARCHAR(255) DEFAULT NULL, thumbnail_size INT DEFAULT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', content_type VARCHAR(255) NOT NULL, INDEX IDX_FEC530A97E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_assigned_tag (content_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', tag_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_1C5E773A84A0A3ED (content_id), INDEX IDX_1C5E773ABAD26311 (tag_id), PRIMARY KEY(content_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_blog_attachment (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', owner_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', thumbnail_name VARCHAR(255) DEFAULT NULL, thumbnail_original_name VARCHAR(255) DEFAULT NULL, thumbnail_mime_type VARCHAR(255) DEFAULT NULL, thumbnail_size INT DEFAULT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_1E4D06657E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_blog_category (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, post_count INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_blog_post (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', category_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_8ABDA81E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_comment (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', target_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', owner_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', parent_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', content VARCHAR(255) DEFAULT NULL, has_replies TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4B7C8BDF158E0B66 (target_id), INDEX IDX_4B7C8BDF7E3C61F9 (owner_id), INDEX IDX_4B7C8BDF727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_podcast_episode (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', season_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', episode_number INT NOT NULL, episode_type VARCHAR(255) NOT NULL, audio_name VARCHAR(255) DEFAULT NULL, audio_original_name VARCHAR(255) DEFAULT NULL, audio_mime_type VARCHAR(255) DEFAULT NULL, audio_size INT DEFAULT NULL, audio_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_F63FD6E74EC001D1 (season_id), UNIQUE INDEX UNIQ_F63FD6E7FAAD804F (episode_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_podcast_progression (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', owner_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', target_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', progress INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EB41E4867E3C61F9 (owner_id), INDEX IDX_EB41E486158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_podcast_season (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, short_code VARCHAR(255) DEFAULT \'S1\' NOT NULL, description LONGTEXT NOT NULL, episode_count INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', thumbnail_name VARCHAR(255) DEFAULT NULL, thumbnail_original_name VARCHAR(255) DEFAULT NULL, thumbnail_mime_type VARCHAR(255) DEFAULT NULL, thumbnail_size INT DEFAULT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_tag (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, content_count INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_B662E1765E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_training_technology (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, video_count INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', thumbnail_name VARCHAR(255) DEFAULT NULL, thumbnail_original_name VARCHAR(255) DEFAULT NULL, thumbnail_mime_type VARCHAR(255) DEFAULT NULL, thumbnail_size INT DEFAULT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', UNIQUE INDEX UNIQ_E1D67B1D5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_training_video (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', source_url VARCHAR(255) NOT NULL, timecodes LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_assigned_technology (content_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', technology_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_63C9A20A84A0A3ED (content_id), INDEX IDX_63C9A20A4235D463 (technology_id), PRIMARY KEY(content_id, technology_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_view (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', owner_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', target_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', ip VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_339F464B7E3C61F9 (owner_id), INDEX IDX_339F464B158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(80) DEFAULT NULL, gender VARCHAR(255) DEFAULT \'M\' NOT NULL, pronouns VARCHAR(10) DEFAULT NULL, job_title VARCHAR(150) DEFAULT NULL, biography LONGTEXT DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, phone_number VARCHAR(15) DEFAULT NULL, country VARCHAR(3) DEFAULT \'CD\', password VARCHAR(4096) DEFAULT NULL, is_subscribed_newsletter TINYINT(1) DEFAULT 0 NOT NULL, is_subscribed_marketing TINYINT(1) DEFAULT 0 NOT NULL, is_dark_theme TINYINT(1) DEFAULT 1 NOT NULL, linkedin_url VARCHAR(255) DEFAULT NULL, twitter_url VARCHAR(255) DEFAULT NULL, github_url VARCHAR(255) DEFAULT NULL, website_url VARCHAR(255) DEFAULT NULL, reset_login_attempts_token VARCHAR(255) DEFAULT NULL, email_verification_token VARCHAR(255) DEFAULT NULL, is_email_verified TINYINT(1) DEFAULT 0 NOT NULL, phone_number_verification_token VARCHAR(255) DEFAULT NULL, is_phone_number_verified TINYINT(1) DEFAULT 0 NOT NULL, is_banned TINYINT(1) DEFAULT 0 NOT NULL, banned_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_login_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_login_ip VARCHAR(255) DEFAULT NULL, github_id VARCHAR(255) DEFAULT NULL, facebook_id VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, is_email_auth_enabled TINYINT(1) DEFAULT 0 NOT NULL, email_auth_code VARCHAR(6) DEFAULT NULL, is_google_auth_enabled TINYINT(1) DEFAULT 0 NOT NULL, google_auth_secret VARCHAR(255) DEFAULT NULL, backup_codes LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', username VARCHAR(30) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', rss_url VARCHAR(255) DEFAULT NULL, avatar_name VARCHAR(255) DEFAULT NULL, avatar_original_name VARCHAR(255) DEFAULT NULL, avatar_mime_type VARCHAR(255) DEFAULT NULL, avatar_size INT DEFAULT NULL, avatar_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', UNIQUE INDEX UNIQ_8D93D6496B01BC5B (phone_number), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auth_login_attempt ADD CONSTRAINT FK_F52C00B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE auth_reset_password_token ADD CONSTRAINT FK_4C7FBB267E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A97E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_assigned_tag ADD CONSTRAINT FK_1C5E773A84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE content_assigned_tag ADD CONSTRAINT FK_1C5E773ABAD26311 FOREIGN KEY (tag_id) REFERENCES content_tag (id)');
        $this->addSql('ALTER TABLE content_blog_attachment ADD CONSTRAINT FK_1E4D06657E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_blog_post ADD CONSTRAINT FK_8ABDA81E12469DE2 FOREIGN KEY (category_id) REFERENCES content_blog_category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE content_blog_post ADD CONSTRAINT FK_8ABDA81EBF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_comment ADD CONSTRAINT FK_4B7C8BDF158E0B66 FOREIGN KEY (target_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_comment ADD CONSTRAINT FK_4B7C8BDF7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_comment ADD CONSTRAINT FK_4B7C8BDF727ACA70 FOREIGN KEY (parent_id) REFERENCES content_comment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_podcast_episode ADD CONSTRAINT FK_F63FD6E74EC001D1 FOREIGN KEY (season_id) REFERENCES content_podcast_season (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE content_podcast_episode ADD CONSTRAINT FK_F63FD6E7BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_podcast_progression ADD CONSTRAINT FK_EB41E4867E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_podcast_progression ADD CONSTRAINT FK_EB41E486158E0B66 FOREIGN KEY (target_id) REFERENCES content_podcast_episode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_training_video ADD CONSTRAINT FK_F9F6AA95BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_assigned_technology ADD CONSTRAINT FK_63C9A20A84A0A3ED FOREIGN KEY (content_id) REFERENCES content_training_video (id)');
        $this->addSql('ALTER TABLE content_assigned_technology ADD CONSTRAINT FK_63C9A20A4235D463 FOREIGN KEY (technology_id) REFERENCES content_training_technology (id)');
        $this->addSql('ALTER TABLE content_view ADD CONSTRAINT FK_339F464B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_view ADD CONSTRAINT FK_339F464B158E0B66 FOREIGN KEY (target_id) REFERENCES content (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE auth_login_attempt DROP FOREIGN KEY FK_F52C00B7E3C61F9');
        $this->addSql('ALTER TABLE auth_reset_password_token DROP FOREIGN KEY FK_4C7FBB267E3C61F9');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A97E3C61F9');
        $this->addSql('ALTER TABLE content_assigned_tag DROP FOREIGN KEY FK_1C5E773A84A0A3ED');
        $this->addSql('ALTER TABLE content_assigned_tag DROP FOREIGN KEY FK_1C5E773ABAD26311');
        $this->addSql('ALTER TABLE content_blog_attachment DROP FOREIGN KEY FK_1E4D06657E3C61F9');
        $this->addSql('ALTER TABLE content_blog_post DROP FOREIGN KEY FK_8ABDA81E12469DE2');
        $this->addSql('ALTER TABLE content_blog_post DROP FOREIGN KEY FK_8ABDA81EBF396750');
        $this->addSql('ALTER TABLE content_comment DROP FOREIGN KEY FK_4B7C8BDF158E0B66');
        $this->addSql('ALTER TABLE content_comment DROP FOREIGN KEY FK_4B7C8BDF7E3C61F9');
        $this->addSql('ALTER TABLE content_comment DROP FOREIGN KEY FK_4B7C8BDF727ACA70');
        $this->addSql('ALTER TABLE content_podcast_episode DROP FOREIGN KEY FK_F63FD6E74EC001D1');
        $this->addSql('ALTER TABLE content_podcast_episode DROP FOREIGN KEY FK_F63FD6E7BF396750');
        $this->addSql('ALTER TABLE content_podcast_progression DROP FOREIGN KEY FK_EB41E4867E3C61F9');
        $this->addSql('ALTER TABLE content_podcast_progression DROP FOREIGN KEY FK_EB41E486158E0B66');
        $this->addSql('ALTER TABLE content_training_video DROP FOREIGN KEY FK_F9F6AA95BF396750');
        $this->addSql('ALTER TABLE content_assigned_technology DROP FOREIGN KEY FK_63C9A20A84A0A3ED');
        $this->addSql('ALTER TABLE content_assigned_technology DROP FOREIGN KEY FK_63C9A20A4235D463');
        $this->addSql('ALTER TABLE content_view DROP FOREIGN KEY FK_339F464B7E3C61F9');
        $this->addSql('ALTER TABLE content_view DROP FOREIGN KEY FK_339F464B158E0B66');
        $this->addSql('DROP TABLE auth_login_attempt');
        $this->addSql('DROP TABLE auth_reset_password_token');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE content_assigned_tag');
        $this->addSql('DROP TABLE content_blog_attachment');
        $this->addSql('DROP TABLE content_blog_category');
        $this->addSql('DROP TABLE content_blog_post');
        $this->addSql('DROP TABLE content_comment');
        $this->addSql('DROP TABLE content_podcast_episode');
        $this->addSql('DROP TABLE content_podcast_progression');
        $this->addSql('DROP TABLE content_podcast_season');
        $this->addSql('DROP TABLE content_tag');
        $this->addSql('DROP TABLE content_training_technology');
        $this->addSql('DROP TABLE content_training_video');
        $this->addSql('DROP TABLE content_assigned_technology');
        $this->addSql('DROP TABLE content_view');
        $this->addSql('DROP TABLE user');
    }
}