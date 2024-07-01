<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701031249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE facture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE facture (id INT NOT NULL, user_id INT NOT NULL, mail VARCHAR(255) NOT NULL, nom_client VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, total_prix DOUBLE PRECISION NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FE866410A76ED395 ON facture (user_id)');
        $this->addSql('COMMENT ON COLUMN facture.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE facture_produit (facture_id INT NOT NULL, produit_id INT NOT NULL, PRIMARY KEY(facture_id, produit_id))');
        $this->addSql('CREATE INDEX IDX_61424D7E7F2DEE08 ON facture_produit (facture_id)');
        $this->addSql('CREATE INDEX IDX_61424D7EF347EFB ON facture_produit (produit_id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE facture_produit ADD CONSTRAINT FK_61424D7E7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE facture_produit ADD CONSTRAINT FK_61424D7EF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE facture_id_seq CASCADE');
        $this->addSql('ALTER TABLE facture DROP CONSTRAINT FK_FE866410A76ED395');
        $this->addSql('ALTER TABLE facture_produit DROP CONSTRAINT FK_61424D7E7F2DEE08');
        $this->addSql('ALTER TABLE facture_produit DROP CONSTRAINT FK_61424D7EF347EFB');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE facture_produit');
    }
}
