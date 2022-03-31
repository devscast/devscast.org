<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20220330153430
 * @package DoctrineMigrations
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20220330153430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create user, login_attempt and reset_password_token';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE authentication_login_attempt (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4F58E06CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE authentication_reset_password_token (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_D4668CE7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) DEFAULT NULL, username VARCHAR(30) NOT NULL, job_title VARCHAR(150) DEFAULT NULL, biography LONGTEXT DEFAULT NULL, gender ENUM(\'M\', \'F\', \'O\'), email VARCHAR(180) DEFAULT NULL, phone_number VARCHAR(15) DEFAULT NULL, country VARCHAR(3) DEFAULT \'CD\', roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(4096) DEFAULT NULL, is_email_verified TINYINT(1) DEFAULT 0 NOT NULL, is_phone_number_verified TINYINT(1) DEFAULT 0 NOT NULL, is_banned TINYINT(1) DEFAULT 0 NOT NULL, banned_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_login_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_login_ip VARCHAR(255) DEFAULT NULL, github_id VARCHAR(255) DEFAULT NULL, facebook_id VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D6496B01BC5B (phone_number), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE authentication_login_attempt ADD CONSTRAINT FK_4F58E06CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE authentication_reset_password_token ADD CONSTRAINT FK_D4668CE7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE authentication_login_attempt DROP FOREIGN KEY FK_4F58E06CA76ED395');
        $this->addSql('ALTER TABLE authentication_reset_password_token DROP FOREIGN KEY FK_D4668CE7A76ED395');
        $this->addSql('DROP TABLE authentication_login_attempt');
        $this->addSql('DROP TABLE authentication_reset_password_token');
        $this->addSql('DROP TABLE user');
    }
}
