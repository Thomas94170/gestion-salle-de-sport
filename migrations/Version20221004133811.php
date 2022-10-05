<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221004133811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE structure_service (structure_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_3A3FEAE32534008B (structure_id), INDEX IDX_3A3FEAE3ED5CA9E6 (service_id), PRIMARY KEY(structure_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE structure_service ADD CONSTRAINT FK_3A3FEAE32534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE structure_service ADD CONSTRAINT FK_3A3FEAE3ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure_service DROP FOREIGN KEY FK_3A3FEAE32534008B');
        $this->addSql('ALTER TABLE structure_service DROP FOREIGN KEY FK_3A3FEAE3ED5CA9E6');
        $this->addSql('DROP TABLE structure_service');
    }
}
