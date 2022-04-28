<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419160010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add refund table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE refund (ulid UUID NOT NULL, contributor_ulid UUID NOT NULL, recipient_ulid UUID NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(ulid))');
        $this->addSql('CREATE INDEX IDX_5B2C145811C09D17 ON refund (contributor_ulid)');
        $this->addSql('CREATE INDEX IDX_5B2C145832B4B226 ON refund (recipient_ulid)');
        $this->addSql('COMMENT ON COLUMN refund.ulid IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN refund.contributor_ulid IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN refund.recipient_ulid IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE refund ADD CONSTRAINT FK_5B2C145811C09D17 FOREIGN KEY (contributor_ulid) REFERENCES contributor (ulid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE refund ADD CONSTRAINT FK_5B2C145832B4B226 FOREIGN KEY (recipient_ulid) REFERENCES contributor (ulid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE refund');
    }
}
