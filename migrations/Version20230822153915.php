<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822153915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE renovacion ADD prescripcion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE renovacion ADD CONSTRAINT FK_E08E54E931A2E37D FOREIGN KEY (prescripcion_id) REFERENCES prescripcion (id)');
        $this->addSql('CREATE INDEX IDX_E08E54E931A2E37D ON renovacion (prescripcion_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE renovacion DROP FOREIGN KEY FK_E08E54E931A2E37D');
        $this->addSql('DROP INDEX IDX_E08E54E931A2E37D ON renovacion');
        $this->addSql('ALTER TABLE renovacion DROP prescripcion_id');
    }
}
