<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231112192856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE privilege_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE privilege (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(900) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE privilege_role (privilege_id INT NOT NULL, role_id INT NOT NULL, PRIMARY KEY(privilege_id, role_id))');
        $this->addSql('CREATE INDEX IDX_97F8DF5F32FB8AEA ON privilege_role (privilege_id)');
        $this->addSql('CREATE INDEX IDX_97F8DF5FD60322AC ON privilege_role (role_id)');
        $this->addSql('ALTER TABLE privilege_role ADD CONSTRAINT FK_97F8DF5F32FB8AEA FOREIGN KEY (privilege_id) REFERENCES privilege (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE privilege_role ADD CONSTRAINT FK_97F8DF5FD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE privilege_id_seq CASCADE');
        $this->addSql('ALTER TABLE privilege_role DROP CONSTRAINT FK_97F8DF5F32FB8AEA');
        $this->addSql('ALTER TABLE privilege_role DROP CONSTRAINT FK_97F8DF5FD60322AC');
        $this->addSql('DROP TABLE privilege');
        $this->addSql('DROP TABLE privilege_role');
    }
}
