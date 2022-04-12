<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412145625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_account ADD salt VARCHAR(255) NOT NULL');
        $this->addSql('COMMENT ON COLUMN user_account.salt IS \'(DC2Type:salt)\'');
        $this->addSql('ALTER TABLE user_account_creation_request ADD salt VARCHAR(255) NOT NULL');
        $this->addSql('COMMENT ON COLUMN user_account_creation_request.salt IS \'(DC2Type:salt)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_account DROP salt');
        $this->addSql('ALTER TABLE user_account_creation_request DROP salt');
    }
}
