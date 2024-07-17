<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220514095131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'поле статус для пользователей';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD status VARCHAR(25) DEFAULT \'password_update\'');
    }

    public function down(Schema $schema): void
    {
       $this->addSql('ALTER TABLE user DROP status');
    }
}
