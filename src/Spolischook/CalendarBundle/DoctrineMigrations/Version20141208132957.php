<?php

namespace Spolischook\CalendarBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141208132957 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE `order` (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, quantity INT NOT NULL, amount INT NOT NULL, currency VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_sale ADD bank_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_sale ADD CONSTRAINT FK_68A3E2A411C8FB41 FOREIGN KEY (bank_id) REFERENCES bank (id)');
        $this->addSql('CREATE INDEX IDX_68A3E2A411C8FB41 ON product_sale (bank_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE `order`');
        $this->addSql('ALTER TABLE product_sale DROP FOREIGN KEY FK_68A3E2A411C8FB41');
        $this->addSql('DROP INDEX IDX_68A3E2A411C8FB41 ON product_sale');
        $this->addSql('ALTER TABLE product_sale DROP bank_id');
    }
}
