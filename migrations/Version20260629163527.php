<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260629163527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Focus Session';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE focus_session (user_id CHAR(36) NOT NULL, task_id CHAR(36) NOT NULL, status VARCHAR(255) NOT NULL, started_at DATETIME NOT NULL, paused_at DATETIME DEFAULT NULL, ended_at DATETIME DEFAULT NULL, paused_seconds INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, id CHAR(36) NOT NULL, INDEX idx_focus_session_user (user_id), INDEX idx_focus_session_task (task_id), INDEX idx_focus_session_status (status), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE focus_session');
    }
}
