<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210602065803 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C6ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_1BDA53C6ED5CA9E6 ON medecin (service_id)');
        $this->addSql('ALTER TABLE sejour ADD medecin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sejour ADD CONSTRAINT FK_96F520284F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('CREATE INDEX IDX_96F520284F31A84 ON sejour (medecin_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C6ED5CA9E6');
        $this->addSql('DROP INDEX IDX_1BDA53C6ED5CA9E6 ON medecin');
        $this->addSql('ALTER TABLE medecin DROP service_id');
        $this->addSql('ALTER TABLE sejour DROP FOREIGN KEY FK_96F520284F31A84');
        $this->addSql('DROP INDEX IDX_96F520284F31A84 ON sejour');
        $this->addSql('ALTER TABLE sejour DROP medecin_id');
    }
}
