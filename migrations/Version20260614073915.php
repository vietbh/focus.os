<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260614073915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Monthly Review';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE monthly_reviews (user_id CHAR(36) NOT NULL, month DATE NOT NULL, major_achievements LONGTEXT NOT NULL, goal_progress LONGTEXT NOT NULL, major_challenges LONGTEXT NOT NULL, lessons_learned LONGTEXT NOT NULL, next_month_focus LONGTEXT NOT NULL, created_at DATETIME NOT NULL, id CHAR(36) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE monthly_reviews');
    }
}
