<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230825184632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute la table professional_experience';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE professional_experience (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, start_date VARCHAR(255) NOT NULL, end_date VARCHAR(255) NOT NULL, enterprise VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE professional_experience');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
