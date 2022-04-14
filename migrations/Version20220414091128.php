<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414091128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add creator refercing UserAccount in household table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE household ADD creator_ulid UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN household.creator_ulid IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE household ADD CONSTRAINT FK_54C32FC0B4008985 FOREIGN KEY (creator_ulid) REFERENCES user_account (ulid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_54C32FC0B4008985 ON household (creator_ulid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE household DROP CONSTRAINT FK_54C32FC0B4008985');
        $this->addSql('DROP INDEX IDX_54C32FC0B4008985');
        $this->addSql('ALTER TABLE household DROP creator_ulid');
    }
}
