<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20220410042502
 * @package DoctrineMigrations
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20220410042502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '2fa supports';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD is_email_auth_enabled TINYINT(1) DEFAULT 0 NOT NULL, ADD email_auth_code VARCHAR(6) DEFAULT NULL, ADD is_google_authenticator_enabled TINYINT(1) DEFAULT 0 NOT NULL, ADD google_authenticator_secret VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP is_email_auth_enabled, DROP email_auth_code, DROP is_google_authenticator_enabled, DROP google_authenticator_secret');
    }
}
