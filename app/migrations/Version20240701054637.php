<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701054637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devis_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE facture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE produit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE devis (id INT NOT NULL, user_id INT NOT NULL, mail VARCHAR(255) NOT NULL, nom_client VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, total_prix DOUBLE PRECISION NOT NULL, statut VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8B27C52BA76ED395 ON devis (user_id)');
        $this->addSql('COMMENT ON COLUMN devis.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE devis_produit (devis_id INT NOT NULL, produit_id INT NOT NULL, PRIMARY KEY(devis_id, produit_id))');
        $this->addSql('CREATE INDEX IDX_BB4B777B41DEFADA ON devis_produit (devis_id)');
        $this->addSql('CREATE INDEX IDX_BB4B777BF347EFB ON devis_produit (produit_id)');
        $this->addSql('CREATE TABLE facture (id INT NOT NULL, user_id INT NOT NULL, mail VARCHAR(255) NOT NULL, nom_client VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, total_prix DOUBLE PRECISION NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FE866410A76ED395 ON facture (user_id)');
        $this->addSql('COMMENT ON COLUMN facture.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE facture_produit (facture_id INT NOT NULL, produit_id INT NOT NULL, PRIMARY KEY(facture_id, produit_id))');
        $this->addSql('CREATE INDEX IDX_61424D7E7F2DEE08 ON facture_produit (facture_id)');
        $this->addSql('CREATE INDEX IDX_61424D7EF347EFB ON facture_produit (produit_id)');
        $this->addSql('CREATE TABLE produit (id INT NOT NULL, user_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT NOT NULL, prix DOUBLE PRECISION NOT NULL, date_create TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_29A5EC27A76ED395 ON produit (user_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(5) NOT NULL, city VARCHAR(150) NOT NULL, is_verified BOOLEAN NOT NULL, reset_token VARCHAR(100) DEFAULT NULL, garage_name VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52BA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devis_produit ADD CONSTRAINT FK_BB4B777B41DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devis_produit ADD CONSTRAINT FK_BB4B777BF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE facture_produit ADD CONSTRAINT FK_61424D7E7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE facture_produit ADD CONSTRAINT FK_61424D7EF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devis_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE facture_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE produit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE devis DROP CONSTRAINT FK_8B27C52BA76ED395');
        $this->addSql('ALTER TABLE devis_produit DROP CONSTRAINT FK_BB4B777B41DEFADA');
        $this->addSql('ALTER TABLE devis_produit DROP CONSTRAINT FK_BB4B777BF347EFB');
        $this->addSql('ALTER TABLE facture DROP CONSTRAINT FK_FE866410A76ED395');
        $this->addSql('ALTER TABLE facture_produit DROP CONSTRAINT FK_61424D7E7F2DEE08');
        $this->addSql('ALTER TABLE facture_produit DROP CONSTRAINT FK_61424D7EF347EFB');
        $this->addSql('ALTER TABLE produit DROP CONSTRAINT FK_29A5EC27A76ED395');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE devis');
        $this->addSql('DROP TABLE devis_produit');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE facture_produit');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE "user"');
    }
}
