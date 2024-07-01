<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701015347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE devis_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE devis (id INT NOT NULL, user_id INT NOT NULL, mail VARCHAR(255) NOT NULL, nom_client VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, total_prix DOUBLE PRECISION NOT NULL, statut VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8B27C52BA76ED395 ON devis (user_id)');
        $this->addSql('COMMENT ON COLUMN devis.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE devis_produit (devis_id INT NOT NULL, produit_id INT NOT NULL, PRIMARY KEY(devis_id, produit_id))');
        $this->addSql('CREATE INDEX IDX_BB4B777B41DEFADA ON devis_produit (devis_id)');
        $this->addSql('CREATE INDEX IDX_BB4B777BF347EFB ON devis_produit (produit_id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52BA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devis_produit ADD CONSTRAINT FK_BB4B777B41DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devis_produit ADD CONSTRAINT FK_BB4B777BF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE devis_id_seq CASCADE');
        $this->addSql('ALTER TABLE devis DROP CONSTRAINT FK_8B27C52BA76ED395');
        $this->addSql('ALTER TABLE devis_produit DROP CONSTRAINT FK_BB4B777B41DEFADA');
        $this->addSql('ALTER TABLE devis_produit DROP CONSTRAINT FK_BB4B777BF347EFB');
        $this->addSql('DROP TABLE devis');
        $this->addSql('DROP TABLE devis_produit');
    }
}
