<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240128115430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dren ADD telephone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE iepp ADD email VARCHAR(255) NOT NULL, ADD telephone VARCHAR(255) NOT NULL, CHANGE parent dren_id INT NOT NULL');
        $this->addSql('ALTER TABLE iepp ADD CONSTRAINT FK_564C6694B7547F6D FOREIGN KEY (dren_id) REFERENCES dren (id)');
        $this->addSql('CREATE INDEX IDX_564C6694B7547F6D ON iepp (dren_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dren DROP telephone');
        $this->addSql('ALTER TABLE iepp DROP FOREIGN KEY FK_564C6694B7547F6D');
        $this->addSql('DROP INDEX IDX_564C6694B7547F6D ON iepp');
        $this->addSql('ALTER TABLE iepp DROP email, DROP telephone, CHANGE dren_id parent INT NOT NULL');
    }
}
