<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221010184206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guardian ADD gendre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guardian ADD CONSTRAINT FK_6448605518068454 FOREIGN KEY (gendre_id) REFERENCES gendre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6448605518068454 ON guardian (gendre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE guardian DROP CONSTRAINT FK_6448605518068454');
        $this->addSql('DROP INDEX IDX_6448605518068454');
        $this->addSql('ALTER TABLE guardian DROP gendre_id');
    }
}
