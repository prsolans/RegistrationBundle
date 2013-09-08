<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130907221717 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Event CHANGE school school INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Event ADD CONSTRAINT FK_FA6F25A3F99EDABB FOREIGN KEY (school) REFERENCES School (id)");
        $this->addSql("CREATE INDEX IDX_FA6F25A3F99EDABB ON Event (school)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Event DROP FOREIGN KEY FK_FA6F25A3F99EDABB");
        $this->addSql("DROP INDEX IDX_FA6F25A3F99EDABB ON Event");
        $this->addSql("ALTER TABLE Event CHANGE school school INT NOT NULL");
    }
}
