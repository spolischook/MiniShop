<?php

namespace Spolischook\CalendarBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141209141200 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE money_transfer ADD deletedAt DATETIME DEFAULT NULL, ADD fromBank_id INT DEFAULT NULL, ADD toBank_id INT DEFAULT NULL, DROP from_account, DROP to_account');
        $this->addSql('ALTER TABLE money_transfer ADD CONSTRAINT FK_A15E50EEAA775E8E FOREIGN KEY (fromBank_id) REFERENCES bank (id)');
        $this->addSql('ALTER TABLE money_transfer ADD CONSTRAINT FK_A15E50EE19429C3 FOREIGN KEY (toBank_id) REFERENCES bank (id)');
        $this->addSql('CREATE INDEX IDX_A15E50EEAA775E8E ON money_transfer (fromBank_id)');
        $this->addSql('CREATE INDEX IDX_A15E50EE19429C3 ON money_transfer (toBank_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE money_transfer DROP FOREIGN KEY FK_A15E50EEAA775E8E');
        $this->addSql('ALTER TABLE money_transfer DROP FOREIGN KEY FK_A15E50EE19429C3');
        $this->addSql('DROP INDEX IDX_A15E50EEAA775E8E ON money_transfer');
        $this->addSql('DROP INDEX IDX_A15E50EE19429C3 ON money_transfer');
        $this->addSql('ALTER TABLE money_transfer ADD from_account VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD to_account VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP deletedAt, DROP fromBank_id, DROP toBank_id');
    }
}
