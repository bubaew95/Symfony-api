<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version91231012173079 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
//        $this->addSql('ALTER TABLE books DROP dispatch');

        $this->addSql("UPDATE `user` SET `first_name` = SUBSTRING_INDEX(`last_sur_name`, ' ', 1), `middle_name` = SUBSTRING_INDEX(SUBSTRING_INDEX(`last_sur_name`, ' ', 2), ' ', -1),`last_name` = SUBSTRING_INDEX(`last_sur_name`, ' ', -1)");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE books ADD dispatch SMALLINT DEFAULT NULL');
    }
}
