<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620213812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD lastname VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD firstname VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD zipcode VARCHAR(5) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD city VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD is_verified BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD reset_token VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP username');
        $this->addSql('ALTER TABLE "user" DROP phone_number');
        $this->addSql('ALTER TABLE "user" DROP zip_code');
        $this->addSql('ALTER TABLE "user" ALTER address SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER INDEX uniq_identifier_email RENAME TO UNIQ_8D93D649E7927C74');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" ADD username VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD phone_number VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD zip_code VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" DROP lastname');
        $this->addSql('ALTER TABLE "user" DROP firstname');
        $this->addSql('ALTER TABLE "user" DROP zipcode');
        $this->addSql('ALTER TABLE "user" DROP city');
        $this->addSql('ALTER TABLE "user" DROP is_verified');
        $this->addSql('ALTER TABLE "user" DROP reset_token');
        $this->addSql('ALTER TABLE "user" DROP created_at');
        $this->addSql('ALTER TABLE "user" ALTER address DROP NOT NULL');
        $this->addSql('ALTER INDEX uniq_8d93d649e7927c74 RENAME TO uniq_identifier_email');
    }
}
