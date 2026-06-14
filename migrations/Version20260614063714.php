<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260614063714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Weekly Review';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE weekly_reviews (user_id CHAR(36) NOT NULL, week_start_date DATE NOT NULL, achievements LONGTEXT NOT NULL, lessons_learned LONGTEXT NOT NULL, improvements LONGTEXT NOT NULL, next_week_focus LONGTEXT NOT NULL, created_at DATETIME NOT NULL, id CHAR(36) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE weekly_reviews');
    }
}
