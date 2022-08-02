<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20220802083831.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20220802083831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'subject proposal';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE content_subject_proposal (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, subject VARCHAR(255) NOT NULL, votes_count INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status ENUM(\'reviewing\', \'rejected\', \'accepted\'), INDEX IDX_3FA4A5E87E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_subject_proposal_vote (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, proposal_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E38B4FD67E3C61F9 (owner_id), INDEX IDX_E38B4FD6F4792058 (proposal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content_subject_proposal ADD CONSTRAINT FK_3FA4A5E87E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_subject_proposal_vote ADD CONSTRAINT FK_E38B4FD67E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_subject_proposal_vote ADD CONSTRAINT FK_E38B4FD6F4792058 FOREIGN KEY (proposal_id) REFERENCES content_subject_proposal (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE content_subject_proposal_vote DROP FOREIGN KEY FK_E38B4FD6F4792058');
        $this->addSql('DROP TABLE content_subject_proposal');
        $this->addSql('DROP TABLE content_subject_proposal_vote');
    }
}
