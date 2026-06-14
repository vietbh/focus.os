<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260613100339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create user table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, avatar VARCHAR(1000) DEFAULT NULL, provider VARCHAR(255) NOT NULL, provider_id VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, id CHAR(36) NOT NULL, INDEX idx_user_email (email), UNIQUE INDEX uniq_user_provider (provider, provider_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users');
    }
}
