<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20231028005726.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20231028005726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add podcast episode guests table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE content_podcast_episode_guests (episode_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', guest_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_363E5AB6362B62A0 (episode_id), INDEX IDX_363E5AB69A4AA658 (guest_id), PRIMARY KEY(episode_id, guest_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content_podcast_episode_guests ADD CONSTRAINT FK_363E5AB6362B62A0 FOREIGN KEY (episode_id) REFERENCES content_podcast_episode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_podcast_episode_guests ADD CONSTRAINT FK_363E5AB69A4AA658 FOREIGN KEY (guest_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE content_podcast_episode_guests DROP FOREIGN KEY FK_363E5AB6362B62A0');
        $this->addSql('ALTER TABLE content_podcast_episode_guests DROP FOREIGN KEY FK_363E5AB69A4AA658');
        $this->addSql('DROP TABLE content_podcast_episode_guests');
    }
}
