<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231020114156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table project';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, featured TINYINT(1) NOT NULL, created_at DATETIME NOT NULL DEFAULT NOW(), updated_at DATETIME NOT NULL DEFAULT NOW(), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE project');
    }
}
