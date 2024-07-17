<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231022110145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review ADD likes INT UNSIGNED DEFAULT NULL, ADD dislikes INT UNSIGNED DEFAULT NULL, DROP voter');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE review ADD voter VARCHAR(255) DEFAULT NULL, DROP likes, DROP dislikes');
    }
}
