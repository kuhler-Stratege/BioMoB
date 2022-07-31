<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220606204734 extends AbstractMigration {
    public function getDescription(): string {
        return 'Migration afgter created a registration form';
    }

    public function up(Schema $schema): void{
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE TABLE Contributer (uuid INT AUTO_INCREMENT NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        //$this->addSql('CREATE TABLE admin (uuid INT AUTO_INCREMENT NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accounts ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void{
        // this down() migration is auto-generated, please modify it to your needs
        //$this->addSql('DROP TABLE Contributer');
        //$this->addSql('DROP TABLE admin');
        $this->addSql('ALTER TABLE Accounts DROP is_verified');
    }
}
