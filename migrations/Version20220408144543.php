<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408144543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributor ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE contributor ALTER name DROP DEFAULT');
        $this->addSql('ALTER TABLE expense ADD registered_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE expense ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE expense ALTER amount TYPE DOUBLE PRECISION');
        $this->addSql('ALTER TABLE expense ALTER amount DROP DEFAULT');
        $this->addSql('ALTER TABLE household ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE household ALTER name DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE household ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE household ALTER name DROP DEFAULT');
        $this->addSql('ALTER TABLE contributor ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE contributor ALTER name DROP DEFAULT');
        $this->addSql('ALTER TABLE expense DROP registered_at');
        $this->addSql('ALTER TABLE expense DROP description');
        $this->addSql('ALTER TABLE expense ALTER amount TYPE DOUBLE PRECISION');
        $this->addSql('ALTER TABLE expense ALTER amount DROP DEFAULT');
    }
}
