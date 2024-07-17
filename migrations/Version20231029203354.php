<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231029203354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_books_read (id INT AUTO_INCREMENT NOT NULL, book_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date DATETIME NOT NULL, page VARCHAR(50) DEFAULT NULL, count TINYINT(3) DEFAULT null,  INDEX IDX_1CB927A416A2B381 (book_id), INDEX IDX_1CB927A4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_books_read ADD CONSTRAINT FK_1CB927A416A2B381 FOREIGN KEY (book_id) REFERENCES books (id)');
        $this->addSql('ALTER TABLE user_books_read ADD CONSTRAINT FK_1CB927A4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_books_read DROP FOREIGN KEY FK_1CB927A416A2B381');
        $this->addSql('ALTER TABLE user_books_read DROP FOREIGN KEY FK_1CB927A4A76ED395');
        $this->addSql('DROP TABLE user_books_read');
    }
}
