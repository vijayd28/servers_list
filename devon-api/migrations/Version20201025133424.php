<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025133424 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE servers (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(36) NOT NULL, model_name VARCHAR(100) NOT NULL, model_slug VARCHAR(120) NOT NULL, ram_size VARCHAR(20) NOT NULL, ram_type VARCHAR(10) NOT NULL, hdd_size VARCHAR(20) NOT NULL, hdd_type VARCHAR(10) NOT NULL, location VARCHAR(100) NOT NULL, price VARCHAR(20) NOT NULL, currency VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(36) NOT NULL, first_name VARCHAR(50) DEFAULT NULL, last_name VARCHAR(50) DEFAULT NULL, email VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE servers');
        $this->addSql('DROP TABLE users');
    }
}
