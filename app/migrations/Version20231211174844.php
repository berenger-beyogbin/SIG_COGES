<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231211174844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE genre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE movie_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE dren_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE iepp_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE dren (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE iepp (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE genre DROP CONSTRAINT fk_835033f88f93b6fc');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE movie');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE dren_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE iepp_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE genre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE movie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE genre (id INT NOT NULL, movie_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_835033f88f93b6fc ON genre (movie_id)');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, title VARCHAR(255) NOT NULL, original_language VARCHAR(255) NOT NULL, original_title VARCHAR(255) NOT NULL, overview VARCHAR(255) NOT NULL, poster_path VARCHAR(255) NOT NULL, backdrop_path VARCHAR(255) NOT NULL, release_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, video BOOLEAN NOT NULL, popularity DOUBLE PRECISION NOT NULL, vote_average DOUBLE PRECISION NOT NULL, vote_count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE genre ADD CONSTRAINT fk_835033f88f93b6fc FOREIGN KEY (movie_id) REFERENCES movie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE dren');
        $this->addSql('DROP TABLE iepp');
    }
}
