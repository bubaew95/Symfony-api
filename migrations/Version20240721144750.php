<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240721144750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE books ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4A1B2A92A76ED395 ON books (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A92A76ED395');
        $this->addSql('DROP INDEX IDX_4A1B2A92A76ED395 ON books');
    }
}
