<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130908081651 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE EventDate CHANGE event event INT DEFAULT NULL, CHANGE status status INT DEFAULT NULL");
        $this->addSql("ALTER TABLE EventDate ADD CONSTRAINT FK_D4F9C6CE3BAE0AA7 FOREIGN KEY (event) REFERENCES Event (id)");
        $this->addSql("ALTER TABLE EventDate ADD CONSTRAINT FK_D4F9C6CE7B00651C FOREIGN KEY (status) REFERENCES DateStatus (id)");
        $this->addSql("CREATE INDEX IDX_D4F9C6CE3BAE0AA7 ON EventDate (event)");
        $this->addSql("CREATE INDEX IDX_D4F9C6CE7B00651C ON EventDate (status)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE EventDate DROP FOREIGN KEY FK_D4F9C6CE3BAE0AA7");
        $this->addSql("ALTER TABLE EventDate DROP FOREIGN KEY FK_D4F9C6CE7B00651C");
        $this->addSql("DROP INDEX IDX_D4F9C6CE3BAE0AA7 ON EventDate");
        $this->addSql("DROP INDEX IDX_D4F9C6CE7B00651C ON EventDate");
        $this->addSql("ALTER TABLE EventDate CHANGE event event INT NOT NULL, CHANGE status status INT NOT NULL");
    }
}
