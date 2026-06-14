<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260614051319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Daily review';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE daily_reviews (user_id CHAR(36) NOT NULL, review_date DATE NOT NULL, completed_work LONGTEXT NOT NULL, wins LONGTEXT NOT NULL, blockers LONGTEXT NOT NULL, focus_tomorrow LONGTEXT NOT NULL, created_at DATETIME NOT NULL, id CHAR(36) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE daily_reviews');
    }
}
