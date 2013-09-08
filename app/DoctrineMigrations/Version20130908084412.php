<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130908084412 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Registration CHANGE add1 add1 VARCHAR(255) DEFAULT NULL, CHANGE add2 add2 VARCHAR(255) DEFAULT NULL, CHANGE add3 add3 VARCHAR(255) DEFAULT NULL, CHANGE add4 add4 VARCHAR(255) DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Registration CHANGE add1 add1 VARCHAR(255) NOT NULL, CHANGE add2 add2 VARCHAR(255) NOT NULL, CHANGE add3 add3 VARCHAR(255) NOT NULL, CHANGE add4 add4 VARCHAR(255) NOT NULL");
    }
}
