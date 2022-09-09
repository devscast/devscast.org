<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20220909222523.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20220909222523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add phone and email verification token';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD email_verification_token VARCHAR(255) DEFAULT NULL, ADD phone_number_verification_token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP email_verification_token, DROP phone_number_verification_token');
    }
}
