<?php

namespace Spolischook\CalendarBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141209183851 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE orders (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, comment LONGTEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, quantity INT NOT NULL, amount INT NOT NULL, currency VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE `order`');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE `order` (id VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, country VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, address VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, phone VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, comment LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, status VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, quantity INT NOT NULL, currency VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, amount INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE orders');
    }
}
