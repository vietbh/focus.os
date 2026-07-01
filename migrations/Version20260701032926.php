<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260701032926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Notification';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification_push_subscriptions (user_id CHAR(36) NOT NULL, endpoint LONGTEXT NOT NULL, public_key LONGTEXT NOT NULL, auth_token LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, id CHAR(36) NOT NULL, INDEX idx_push_subscription_user (user_id), INDEX idx_push_subscription_created_at (created_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE notification_push_subscriptions');
    }
}
