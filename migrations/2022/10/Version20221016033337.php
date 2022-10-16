<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20221016033337.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20221016033337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'content rating, post_list, post_series, technologies';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE content_assigned_technology (content_id INT NOT NULL, technology_id INT NOT NULL, INDEX IDX_63C9A20A84A0A3ED (content_id), INDEX IDX_63C9A20A4235D463 (technology_id), PRIMARY KEY(content_id, technology_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_rating (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, target_id INT NOT NULL, rating SMALLINT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B0BF568E7E3C61F9 (owner_id), INDEX IDX_B0BF568E158E0B66 (target_id), UNIQUE INDEX UNIQ_B0BF568E158E0B667E3C61F9 (target_id, owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_list (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_public TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8D9D9F137E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_series (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, technology_id INT DEFAULT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(300) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\'), thumbnail_name VARCHAR(255) DEFAULT NULL, thumbnail_original_name VARCHAR(255) DEFAULT NULL, thumbnail_mime_type VARCHAR(255) DEFAULT NULL, thumbnail_size INT DEFAULT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_A32E5487E3C61F9 (owner_id), INDEX IDX_A32E5484235D463 (technology_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technology (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', thumbnail_name VARCHAR(255) DEFAULT NULL, thumbnail_original_name VARCHAR(255) DEFAULT NULL, thumbnail_mime_type VARCHAR(255) DEFAULT NULL, thumbnail_size INT DEFAULT NULL, thumbnail_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content_assigned_technology ADD CONSTRAINT FK_63C9A20A84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE content_assigned_technology ADD CONSTRAINT FK_63C9A20A4235D463 FOREIGN KEY (technology_id) REFERENCES technology (id)');
        $this->addSql('ALTER TABLE content_rating ADD CONSTRAINT FK_B0BF568E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_rating ADD CONSTRAINT FK_B0BF568E158E0B66 FOREIGN KEY (target_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_list ADD CONSTRAINT FK_8D9D9F137E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_series ADD CONSTRAINT FK_A32E5487E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_series ADD CONSTRAINT FK_A32E5484235D463 FOREIGN KEY (technology_id) REFERENCES technology (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE content CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\'), CHANGE education_level education_level ENUM(\'beginner\', \'intermediate\', \'advanced\')');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status ENUM(\'reviewing\', \'rejected\', \'accepted\')');
        $this->addSql('ALTER TABLE podcast_episode CHANGE episode_type episode_type ENUM(\'Full\', \'Bonus\', \'Trailer\')');
        $this->addSql('ALTER TABLE user CHANGE gender gender ENUM(\'M\', \'F\', \'O\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE content_assigned_technology DROP FOREIGN KEY FK_63C9A20A4235D463');
        $this->addSql('ALTER TABLE post_series DROP FOREIGN KEY FK_A32E5484235D463');
        $this->addSql('DROP TABLE content_assigned_technology');
        $this->addSql('DROP TABLE content_rating');
        $this->addSql('DROP TABLE post_list');
        $this->addSql('DROP TABLE post_series');
        $this->addSql('DROP TABLE technology');
        $this->addSql('ALTER TABLE content CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE education_level education_level VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE podcast_episode CHANGE episode_type episode_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE gender gender VARCHAR(255) DEFAULT NULL');
    }
}
