<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130908083810 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Registration CHANGE eventdate eventdate INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Registration ADD CONSTRAINT FK_7A997C5FF63AEB53 FOREIGN KEY (eventdate) REFERENCES EventDate (id)");
        $this->addSql("CREATE INDEX IDX_7A997C5FF63AEB53 ON Registration (eventdate)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Registration DROP FOREIGN KEY FK_7A997C5FF63AEB53");
        $this->addSql("DROP INDEX IDX_7A997C5FF63AEB53 ON Registration");
        $this->addSql("ALTER TABLE Registration CHANGE eventdate eventdate INT NOT NULL");
    }
}
