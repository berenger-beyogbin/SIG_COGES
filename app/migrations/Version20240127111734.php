<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240127111734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coges (id INT AUTO_INCREMENT NOT NULL, iddren_id INT NOT NULL, idiepp_id INT NOT NULL, libelle_coges VARCHAR(255) NOT NULL, cycle INT NOT NULL, numero_compte VARCHAR(24) NOT NULL, domiciliation VARCHAR(100) NOT NULL, liste_ets VARCHAR(100) NOT NULL, groupe_scolaire TINYINT(1) NOT NULL, INDEX IDX_E7EB7F1468502D03 (iddren_id), INDEX IDX_E7EB7F14F9246BE (idiepp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etablissement (id INT AUTO_INCREMENT NOT NULL, iddren_id INT NOT NULL, idiepp_id INT NOT NULL, nom VARCHAR(255) NOT NULL, localite VARCHAR(255) NOT NULL, type_milieu VARCHAR(50) NOT NULL, cycle VARCHAR(50) NOT NULL, code_ets VARCHAR(10) NOT NULL, INDEX IDX_20FD592C68502D03 (iddren_id), INDEX IDX_20FD592CF9246BE (idiepp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coges ADD CONSTRAINT FK_E7EB7F1468502D03 FOREIGN KEY (iddren_id) REFERENCES dren (id)');
        $this->addSql('ALTER TABLE coges ADD CONSTRAINT FK_E7EB7F14F9246BE FOREIGN KEY (idiepp_id) REFERENCES iepp (id)');
        $this->addSql('ALTER TABLE etablissement ADD CONSTRAINT FK_20FD592C68502D03 FOREIGN KEY (iddren_id) REFERENCES dren (id)');
        $this->addSql('ALTER TABLE etablissement ADD CONSTRAINT FK_20FD592CF9246BE FOREIGN KEY (idiepp_id) REFERENCES iepp (id)');
        $this->addSql('ALTER TABLE iepp ADD iddren_id INT NOT NULL, ADD parent INT NOT NULL');
        $this->addSql('ALTER TABLE iepp ADD CONSTRAINT FK_564C669468502D03 FOREIGN KEY (iddren_id) REFERENCES dren (id)');
        $this->addSql('CREATE INDEX IDX_564C669468502D03 ON iepp (iddren_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coges DROP FOREIGN KEY FK_E7EB7F1468502D03');
        $this->addSql('ALTER TABLE coges DROP FOREIGN KEY FK_E7EB7F14F9246BE');
        $this->addSql('ALTER TABLE etablissement DROP FOREIGN KEY FK_20FD592C68502D03');
        $this->addSql('ALTER TABLE etablissement DROP FOREIGN KEY FK_20FD592CF9246BE');
        $this->addSql('DROP TABLE coges');
        $this->addSql('DROP TABLE etablissement');
        $this->addSql('ALTER TABLE iepp DROP FOREIGN KEY FK_564C669468502D03');
        $this->addSql('DROP INDEX IDX_564C669468502D03 ON iepp');
        $this->addSql('ALTER TABLE iepp DROP iddren_id, DROP parent');
    }
}
