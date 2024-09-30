<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240824122253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner ADD author_id INT NOT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE image partner_image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_312B3E16F675F31B ON partner (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E16F675F31B');
        $this->addSql('DROP INDEX IDX_312B3E16F675F31B ON partner');
        $this->addSql('ALTER TABLE partner DROP author_id, DROP updated_at, DROP created_at, CHANGE partner_image image VARCHAR(255) NOT NULL');
    }
}
