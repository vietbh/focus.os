<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260613132817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creat Task and task status history';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task_status_histories (task_id CHAR(36) NOT NULL, from_status VARCHAR(255) NOT NULL, to_status VARCHAR(255) NOT NULL, occurred_at DATETIME NOT NULL, id VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tasks (user_id CHAR(36) NOT NULL, area_id CHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, next_action VARCHAR(500) NOT NULL, status VARCHAR(255) NOT NULL, estimated_minutes INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, id CHAR(36) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE task_status_histories');
        $this->addSql('DROP TABLE tasks');
    }
}
