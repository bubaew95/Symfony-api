<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version90231012173079 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        foreach (glob(__DIR__.'/data/*.sql') as $item) {
            $this->addSql(file_get_contents($item));
        }
    }

    public function down(Schema $schema): void
    {
    }
}
