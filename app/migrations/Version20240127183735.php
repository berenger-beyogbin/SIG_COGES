<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240127183735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activites (id INT AUTO_INCREMENT NOT NULL, idchapitre_id INT NOT NULL, libelle_activite VARCHAR(100) NOT NULL, INDEX IDX_766B5EB5D97F9FD4 (idchapitre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapitres (id INT AUTO_INCREMENT NOT NULL, libelle_chapitre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coges (id INT AUTO_INCREMENT NOT NULL, iddren_id INT NOT NULL, idiepp_id INT NOT NULL, libelle_coges VARCHAR(255) NOT NULL, cycle INT NOT NULL, numero_compte VARCHAR(24) NOT NULL, domiciliation VARCHAR(100) NOT NULL, liste_ets VARCHAR(100) NOT NULL, groupe_scolaire TINYINT(1) NOT NULL, INDEX IDX_E7EB7F1468502D03 (iddren_id), INDEX IDX_E7EB7F14F9246BE (idiepp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depenses (id INT AUTO_INCREMENT NOT NULL, idchapitre_id INT NOT NULL, idactivites_id INT NOT NULL, idpacc_id INT NOT NULL, montant_depense INT NOT NULL, fichier_preuve VARCHAR(255) DEFAULT NULL, nom_fichier_preuve VARCHAR(255) DEFAULT NULL, date_exe DATE DEFAULT NULL, heure_exe TIME DEFAULT NULL, paiement_fournisseur TINYINT(1) NOT NULL, INDEX IDX_EE350ECBD97F9FD4 (idchapitre_id), INDEX IDX_EE350ECB1D234EBE (idactivites_id), INDEX IDX_EE350ECB3A9C896 (idpacc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dren (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etablissement (id INT AUTO_INCREMENT NOT NULL, iddren_id INT NOT NULL, idiepp_id INT NOT NULL, nom VARCHAR(255) NOT NULL, localite VARCHAR(255) NOT NULL, type_milieu VARCHAR(50) NOT NULL, cycle VARCHAR(50) NOT NULL, code_ets VARCHAR(10) NOT NULL, INDEX IDX_20FD592C68502D03 (iddren_id), INDEX IDX_20FD592CF9246BE (idiepp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseurs (id INT AUTO_INCREMENT NOT NULL, nom_prenoms VARCHAR(255) NOT NULL, contact VARCHAR(50) NOT NULL, entreprise VARCHAR(100) NOT NULL, activite VARCHAR(100) NOT NULL, localite VARCHAR(100) NOT NULL, rib VARCHAR(24) NOT NULL, domiciliation VARCHAR(100) NOT NULL, intitule_compte VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE iepp (id INT AUTO_INCREMENT NOT NULL, iddren_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, parent INT NOT NULL, INDEX IDX_564C669468502D03 (iddren_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mandat_coges (id INT AUTO_INCREMENT NOT NULL, idcoges_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_4AA4602C48C4D8BF (idcoges_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre_organe (id INT AUTO_INCREMENT NOT NULL, idorgane_id INT NOT NULL, idposte_id INT NOT NULL, idmandat_id INT NOT NULL, nom_prenoms VARCHAR(255) NOT NULL, genre VARCHAR(10) NOT NULL, profession VARCHAR(50) NOT NULL, contact VARCHAR(50) NOT NULL, INDEX IDX_78398769CBFE1968 (idorgane_id), INDEX IDX_78398769A45188B (idposte_id), INDEX IDX_78398769B89C746D (idmandat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organe_coges (id INT AUTO_INCREMENT NOT NULL, libelle_organe VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pacc (id INT AUTO_INCREMENT NOT NULL, idmandat_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, chemin_fichier VARCHAR(255) NOT NULL, nom_fichier VARCHAR(255) NOT NULL, INDEX IDX_9905D611B89C746D (idmandat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_organe (id INT AUTO_INCREMENT NOT NULL, idorgane_id INT NOT NULL, libelle_poste VARCHAR(100) NOT NULL, INDEX IDX_32E60DD5CBFE1968 (idorgane_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recettes (id INT AUTO_INCREMENT NOT NULL, idpacc_id INT NOT NULL, idsources_id INT NOT NULL, montant_recettes INT NOT NULL, INDEX IDX_EB48E72C3A9C896 (idpacc_id), INDEX IDX_EB48E72C10F8CDCD (idsources_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sources (id INT AUTO_INCREMENT NOT NULL, libelle_sources VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activites ADD CONSTRAINT FK_766B5EB5D97F9FD4 FOREIGN KEY (idchapitre_id) REFERENCES chapitres (id)');
        $this->addSql('ALTER TABLE coges ADD CONSTRAINT FK_E7EB7F1468502D03 FOREIGN KEY (iddren_id) REFERENCES dren (id)');
        $this->addSql('ALTER TABLE coges ADD CONSTRAINT FK_E7EB7F14F9246BE FOREIGN KEY (idiepp_id) REFERENCES iepp (id)');
        $this->addSql('ALTER TABLE depenses ADD CONSTRAINT FK_EE350ECBD97F9FD4 FOREIGN KEY (idchapitre_id) REFERENCES chapitres (id)');
        $this->addSql('ALTER TABLE depenses ADD CONSTRAINT FK_EE350ECB1D234EBE FOREIGN KEY (idactivites_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE depenses ADD CONSTRAINT FK_EE350ECB3A9C896 FOREIGN KEY (idpacc_id) REFERENCES pacc (id)');
        $this->addSql('ALTER TABLE etablissement ADD CONSTRAINT FK_20FD592C68502D03 FOREIGN KEY (iddren_id) REFERENCES dren (id)');
        $this->addSql('ALTER TABLE etablissement ADD CONSTRAINT FK_20FD592CF9246BE FOREIGN KEY (idiepp_id) REFERENCES iepp (id)');
        $this->addSql('ALTER TABLE iepp ADD CONSTRAINT FK_564C669468502D03 FOREIGN KEY (iddren_id) REFERENCES dren (id)');
        $this->addSql('ALTER TABLE mandat_coges ADD CONSTRAINT FK_4AA4602C48C4D8BF FOREIGN KEY (idcoges_id) REFERENCES coges (id)');
        $this->addSql('ALTER TABLE membre_organe ADD CONSTRAINT FK_78398769CBFE1968 FOREIGN KEY (idorgane_id) REFERENCES organe_coges (id)');
        $this->addSql('ALTER TABLE membre_organe ADD CONSTRAINT FK_78398769A45188B FOREIGN KEY (idposte_id) REFERENCES poste_organe (id)');
        $this->addSql('ALTER TABLE membre_organe ADD CONSTRAINT FK_78398769B89C746D FOREIGN KEY (idmandat_id) REFERENCES mandat_coges (id)');
        $this->addSql('ALTER TABLE pacc ADD CONSTRAINT FK_9905D611B89C746D FOREIGN KEY (idmandat_id) REFERENCES mandat_coges (id)');
        $this->addSql('ALTER TABLE poste_organe ADD CONSTRAINT FK_32E60DD5CBFE1968 FOREIGN KEY (idorgane_id) REFERENCES organe_coges (id)');
        $this->addSql('ALTER TABLE recettes ADD CONSTRAINT FK_EB48E72C3A9C896 FOREIGN KEY (idpacc_id) REFERENCES pacc (id)');
        $this->addSql('ALTER TABLE recettes ADD CONSTRAINT FK_EB48E72C10F8CDCD FOREIGN KEY (idsources_id) REFERENCES sources (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activites DROP FOREIGN KEY FK_766B5EB5D97F9FD4');
        $this->addSql('ALTER TABLE coges DROP FOREIGN KEY FK_E7EB7F1468502D03');
        $this->addSql('ALTER TABLE coges DROP FOREIGN KEY FK_E7EB7F14F9246BE');
        $this->addSql('ALTER TABLE depenses DROP FOREIGN KEY FK_EE350ECBD97F9FD4');
        $this->addSql('ALTER TABLE depenses DROP FOREIGN KEY FK_EE350ECB1D234EBE');
        $this->addSql('ALTER TABLE depenses DROP FOREIGN KEY FK_EE350ECB3A9C896');
        $this->addSql('ALTER TABLE etablissement DROP FOREIGN KEY FK_20FD592C68502D03');
        $this->addSql('ALTER TABLE etablissement DROP FOREIGN KEY FK_20FD592CF9246BE');
        $this->addSql('ALTER TABLE iepp DROP FOREIGN KEY FK_564C669468502D03');
        $this->addSql('ALTER TABLE mandat_coges DROP FOREIGN KEY FK_4AA4602C48C4D8BF');
        $this->addSql('ALTER TABLE membre_organe DROP FOREIGN KEY FK_78398769CBFE1968');
        $this->addSql('ALTER TABLE membre_organe DROP FOREIGN KEY FK_78398769A45188B');
        $this->addSql('ALTER TABLE membre_organe DROP FOREIGN KEY FK_78398769B89C746D');
        $this->addSql('ALTER TABLE pacc DROP FOREIGN KEY FK_9905D611B89C746D');
        $this->addSql('ALTER TABLE poste_organe DROP FOREIGN KEY FK_32E60DD5CBFE1968');
        $this->addSql('ALTER TABLE recettes DROP FOREIGN KEY FK_EB48E72C3A9C896');
        $this->addSql('ALTER TABLE recettes DROP FOREIGN KEY FK_EB48E72C10F8CDCD');
        $this->addSql('DROP TABLE activites');
        $this->addSql('DROP TABLE chapitres');
        $this->addSql('DROP TABLE coges');
        $this->addSql('DROP TABLE depenses');
        $this->addSql('DROP TABLE dren');
        $this->addSql('DROP TABLE etablissement');
        $this->addSql('DROP TABLE fournisseurs');
        $this->addSql('DROP TABLE iepp');
        $this->addSql('DROP TABLE mandat_coges');
        $this->addSql('DROP TABLE membre_organe');
        $this->addSql('DROP TABLE organe_coges');
        $this->addSql('DROP TABLE pacc');
        $this->addSql('DROP TABLE poste_organe');
        $this->addSql('DROP TABLE recettes');
        $this->addSql('DROP TABLE sources');
    }
}
