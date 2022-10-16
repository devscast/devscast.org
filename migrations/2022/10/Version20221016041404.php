<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20221016041404.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20221016041404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add posts to post list';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE post_list_assigned_post (post_list_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_7B69627F46A1B8 (post_list_id), INDEX IDX_7B69627F4B89032C (post_id), PRIMARY KEY(post_list_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_list_assigned_post ADD CONSTRAINT FK_7B69627F46A1B8 FOREIGN KEY (post_list_id) REFERENCES post_list (id)');
        $this->addSql('ALTER TABLE post_list_assigned_post ADD CONSTRAINT FK_7B69627F4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE content CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\'), CHANGE education_level education_level ENUM(\'beginner\', \'intermediate\', \'advanced\')');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status ENUM(\'reviewing\', \'rejected\', \'accepted\')');
        $this->addSql('ALTER TABLE podcast_episode CHANGE episode_type episode_type ENUM(\'Full\', \'Bonus\', \'Trailer\')');
        $this->addSql('ALTER TABLE post_series CHANGE status status ENUM(\'draft\', \'reviewing\', \'rejected\', \'published\')');
        $this->addSql('ALTER TABLE user CHANGE gender gender ENUM(\'M\', \'F\', \'O\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE post_list_assigned_post');
        $this->addSql('ALTER TABLE content CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE education_level education_level VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_subject_proposal CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE podcast_episode CHANGE episode_type episode_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE post_series CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE gender gender VARCHAR(255) DEFAULT NULL');
    }
}
