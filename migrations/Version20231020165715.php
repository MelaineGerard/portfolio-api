<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231020165715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute la table professional_experience et modifie la table project';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE professional_experience (id INT AUTO_INCREMENT NOT NULL, enterprise VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, url VARCHAR(255) NOT NULL, start_date VARCHAR(255) NOT NULL, end_date VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE professional_experience');
        $this->addSql('ALTER TABLE project CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
