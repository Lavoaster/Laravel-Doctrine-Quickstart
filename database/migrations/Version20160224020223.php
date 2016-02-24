<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160224020223 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT fk_50586597a76ed395');
        $this->addSql('DROP INDEX idx_50586597a76ed395');
        $this->addSql('ALTER TABLE tasks RENAME COLUMN user_id TO created_by_id');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_50586597B03A8386 ON tasks (created_by_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT FK_50586597B03A8386');
        $this->addSql('DROP INDEX IDX_50586597B03A8386');
        $this->addSql('ALTER TABLE tasks RENAME COLUMN created_by_id TO user_id');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT fk_50586597a76ed395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_50586597a76ed395 ON tasks (user_id)');
    }
}
