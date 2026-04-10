<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260202071038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE created created DATETIME NOT NULL, CHANGE updated updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE product RENAME INDEX referance_unique TO UNIQ_IDENTIFIER_REFERANCE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE updated updated DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE product RENAME INDEX uniq_identifier_referance TO referance_UNIQUE');
    }
}
