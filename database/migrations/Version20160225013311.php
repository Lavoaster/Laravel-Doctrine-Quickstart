<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160225013311 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE sessions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE auth_codes (id VARCHAR(40) NOT NULL, redirect_uri VARCHAR(255) NOT NULL, expire_time VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE auth_code_scopes (auth_code_id VARCHAR(40) NOT NULL, scope_id VARCHAR(40) NOT NULL, PRIMARY KEY(auth_code_id, scope_id))');
        $this->addSql('CREATE INDEX IDX_B740C90A69FEDEE4 ON auth_code_scopes (auth_code_id)');
        $this->addSql('CREATE INDEX IDX_B740C90A682B5931 ON auth_code_scopes (scope_id)');
        $this->addSql('CREATE TABLE clients (id VARCHAR(40) NOT NULL, secret VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E74BF3967505CA2E8E5 ON clients (id, secret)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E745E237E06 ON clients (name)');
        $this->addSql('CREATE TABLE client_scopes (client_id VARCHAR(40) NOT NULL, scope_id VARCHAR(40) NOT NULL, PRIMARY KEY(client_id, scope_id))');
        $this->addSql('CREATE INDEX IDX_5172A88319EB6921 ON client_scopes (client_id)');
        $this->addSql('CREATE INDEX IDX_5172A883682B5931 ON client_scopes (scope_id)');
        $this->addSql('CREATE TABLE client_grants (client_id VARCHAR(40) NOT NULL, grant_id VARCHAR(40) NOT NULL, PRIMARY KEY(client_id, grant_id))');
        $this->addSql('CREATE INDEX IDX_310B8C6519EB6921 ON client_grants (client_id)');
        $this->addSql('CREATE INDEX IDX_310B8C655C0C89F3 ON client_grants (grant_id)');
        $this->addSql('CREATE TABLE client_endpoints (id VARCHAR(40) NOT NULL, client_id VARCHAR(40) DEFAULT NULL, redirect_uri VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_373DF5BF19EB6921 ON client_endpoints (client_id)');
        $this->addSql('CREATE TABLE grants (id VARCHAR(40) NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE grant_scope (grant_id VARCHAR(40) NOT NULL, scope_id VARCHAR(40) NOT NULL, PRIMARY KEY(grant_id, scope_id))');
        $this->addSql('CREATE INDEX IDX_4DDFAC485C0C89F3 ON grant_scope (grant_id)');
        $this->addSql('CREATE INDEX IDX_4DDFAC48682B5931 ON grant_scope (scope_id)');
        $this->addSql('CREATE TABLE scopes (id VARCHAR(40) NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sessions (id INT NOT NULL, client_id VARCHAR(40) DEFAULT NULL, owner_type VARCHAR(255) DEFAULT \'user\' NOT NULL, owner_id VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9A609D1319EB6921 ON sessions (client_id)');
        $this->addSql('CREATE INDEX IDX_9A609D1319EB69211A7834B97E3C61F9 ON sessions (client_id, owner_type, owner_id)');
        $this->addSql('CREATE TABLE session_scopes (session_id INT NOT NULL, scope_id VARCHAR(40) NOT NULL, PRIMARY KEY(session_id, scope_id))');
        $this->addSql('CREATE INDEX IDX_6BBFE969613FECDF ON session_scopes (session_id)');
        $this->addSql('CREATE INDEX IDX_6BBFE969682B5931 ON session_scopes (scope_id)');
        $this->addSql('ALTER TABLE auth_code_scopes ADD CONSTRAINT FK_B740C90A69FEDEE4 FOREIGN KEY (auth_code_id) REFERENCES auth_codes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_code_scopes ADD CONSTRAINT FK_B740C90A682B5931 FOREIGN KEY (scope_id) REFERENCES scopes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client_scopes ADD CONSTRAINT FK_5172A88319EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client_scopes ADD CONSTRAINT FK_5172A883682B5931 FOREIGN KEY (scope_id) REFERENCES scopes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client_grants ADD CONSTRAINT FK_310B8C6519EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client_grants ADD CONSTRAINT FK_310B8C655C0C89F3 FOREIGN KEY (grant_id) REFERENCES grants (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client_endpoints ADD CONSTRAINT FK_373DF5BF19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grant_scope ADD CONSTRAINT FK_4DDFAC485C0C89F3 FOREIGN KEY (grant_id) REFERENCES grants (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grant_scope ADD CONSTRAINT FK_4DDFAC48682B5931 FOREIGN KEY (scope_id) REFERENCES scopes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sessions ADD CONSTRAINT FK_9A609D1319EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session_scopes ADD CONSTRAINT FK_6BBFE969613FECDF FOREIGN KEY (session_id) REFERENCES sessions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session_scopes ADD CONSTRAINT FK_6BBFE969682B5931 FOREIGN KEY (scope_id) REFERENCES scopes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE auth_code_scopes DROP CONSTRAINT FK_B740C90A69FEDEE4');
        $this->addSql('ALTER TABLE client_scopes DROP CONSTRAINT FK_5172A88319EB6921');
        $this->addSql('ALTER TABLE client_grants DROP CONSTRAINT FK_310B8C6519EB6921');
        $this->addSql('ALTER TABLE client_endpoints DROP CONSTRAINT FK_373DF5BF19EB6921');
        $this->addSql('ALTER TABLE sessions DROP CONSTRAINT FK_9A609D1319EB6921');
        $this->addSql('ALTER TABLE client_grants DROP CONSTRAINT FK_310B8C655C0C89F3');
        $this->addSql('ALTER TABLE grant_scope DROP CONSTRAINT FK_4DDFAC485C0C89F3');
        $this->addSql('ALTER TABLE auth_code_scopes DROP CONSTRAINT FK_B740C90A682B5931');
        $this->addSql('ALTER TABLE client_scopes DROP CONSTRAINT FK_5172A883682B5931');
        $this->addSql('ALTER TABLE grant_scope DROP CONSTRAINT FK_4DDFAC48682B5931');
        $this->addSql('ALTER TABLE session_scopes DROP CONSTRAINT FK_6BBFE969682B5931');
        $this->addSql('ALTER TABLE session_scopes DROP CONSTRAINT FK_6BBFE969613FECDF');
        $this->addSql('DROP SEQUENCE sessions_id_seq CASCADE');
        $this->addSql('DROP TABLE auth_codes');
        $this->addSql('DROP TABLE auth_code_scopes');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE client_scopes');
        $this->addSql('DROP TABLE client_grants');
        $this->addSql('DROP TABLE client_endpoints');
        $this->addSql('DROP TABLE grants');
        $this->addSql('DROP TABLE grant_scope');
        $this->addSql('DROP TABLE scopes');
        $this->addSql('DROP TABLE sessions');
        $this->addSql('DROP TABLE session_scopes');
    }
}
