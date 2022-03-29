<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408131838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contributor (ulid UUID NOT NULL, household_ulid UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(ulid))');
        $this->addSql('CREATE INDEX IDX_DA6F9793C3D75FB8 ON contributor (household_ulid)');
        $this->addSql('COMMENT ON COLUMN contributor.ulid IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN contributor.household_ulid IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE expense (ulid UUID NOT NULL, contributor_ulid UUID NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(ulid))');
        $this->addSql('CREATE INDEX IDX_2D3A8DA611C09D17 ON expense (contributor_ulid)');
        $this->addSql('COMMENT ON COLUMN expense.ulid IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN expense.contributor_ulid IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE household (ulid UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(ulid))');
        $this->addSql('COMMENT ON COLUMN household.ulid IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE contributor ADD CONSTRAINT FK_DA6F9793C3D75FB8 FOREIGN KEY (household_ulid) REFERENCES household (ulid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA611C09D17 FOREIGN KEY (contributor_ulid) REFERENCES contributor (ulid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expense DROP CONSTRAINT FK_2D3A8DA611C09D17');
        $this->addSql('ALTER TABLE contributor DROP CONSTRAINT FK_DA6F9793C3D75FB8');
        $this->addSql('DROP TABLE contributor');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE household');
    }
}
