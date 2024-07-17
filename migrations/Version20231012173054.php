<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231012173054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE books ADD publisher VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE books ADD isbn VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE books ADD dispatch SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE books DROP isbn');
    }
}
