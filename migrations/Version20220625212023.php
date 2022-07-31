<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220625212023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Index hinzugefugt, damit E-Mail unique bleibt';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE accounts CHANGE username name VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX eMail_index ON accounts (eMail)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX eMail_index ON Accounts');
        //$this->addSql('ALTER TABLE Accounts CHANGE name username VARCHAR(255) NOT NULL');
    }
}
