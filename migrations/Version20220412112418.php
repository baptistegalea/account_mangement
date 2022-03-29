<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412112418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_account (ulid UUID NOT NULL, email VARCHAR(255) NOT NULL, hashed_password TEXT NOT NULL, name VARCHAR(255) NOT NULL, registered_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(ulid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_253B48AEE7927C74 ON user_account (email)');
        $this->addSql('COMMENT ON COLUMN user_account.ulid IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE user_account_creation_request (ulid UUID NOT NULL, email VARCHAR(255) NOT NULL, hashed_password TEXT NOT NULL, name VARCHAR(255) NOT NULL, one_time_password VARCHAR(8) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(ulid))');
        $this->addSql('COMMENT ON COLUMN user_account_creation_request.ulid IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN user_account_creation_request.one_time_password IS \'(DC2Type:one_time_password)\'');
        $this->addSql('ALTER TABLE contributor ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE contributor ALTER name DROP DEFAULT');
        $this->addSql('ALTER TABLE expense ALTER amount TYPE DOUBLE PRECISION');
        $this->addSql('ALTER TABLE expense ALTER amount DROP DEFAULT');
        $this->addSql('ALTER TABLE expense ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE expense ALTER description DROP DEFAULT');
        $this->addSql('ALTER TABLE household ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE household ALTER name DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE user_account');
        $this->addSql('DROP TABLE user_account_creation_request');
        $this->addSql('ALTER TABLE household ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE household ALTER name DROP DEFAULT');
        $this->addSql('ALTER TABLE contributor ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE contributor ALTER name DROP DEFAULT');
        $this->addSql('ALTER TABLE expense ALTER amount TYPE DOUBLE PRECISION');
        $this->addSql('ALTER TABLE expense ALTER amount DROP DEFAULT');
        $this->addSql('ALTER TABLE expense ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE expense ALTER description DROP DEFAULT');
    }
}
