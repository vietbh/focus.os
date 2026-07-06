<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260705114604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Workspaces';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workspaces (owner_id CHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, icon VARCHAR(100) DEFAULT NULL, color VARCHAR(30) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, id CHAR(36) NOT NULL, INDEX idx_workspace_owner (owner_id), UNIQUE INDEX uniq_workspace_owner_name (owner_id, name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE user_preferences ADD current_workspace_id CHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_preferences ADD CONSTRAINT FK_402A6F607D65B4C4 FOREIGN KEY (current_workspace_id) REFERENCES workspaces (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_402A6F607D65B4C4 ON user_preferences (current_workspace_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE workspaces');
        $this->addSql('ALTER TABLE user_preferences DROP FOREIGN KEY FK_402A6F607D65B4C4');
        $this->addSql('DROP INDEX IDX_402A6F607D65B4C4 ON user_preferences');
        $this->addSql('ALTER TABLE user_preferences DROP current_workspace_id');
    }
}
