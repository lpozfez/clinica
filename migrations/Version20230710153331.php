<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710153331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consulta ADD paciente_id INT NOT NULL, ADD tipo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE7310DAD4 FOREIGN KEY (paciente_id) REFERENCES paciente (id)');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDEA9276E6C FOREIGN KEY (tipo_id) REFERENCES tipo_consulta (id)');
        $this->addSql('CREATE INDEX IDX_A6FE3FDE7310DAD4 ON consulta (paciente_id)');
        $this->addSql('CREATE INDEX IDX_A6FE3FDEA9276E6C ON consulta (tipo_id)');
        $this->addSql('ALTER TABLE paciente ADD user_id INT DEFAULT NULL, ADD seguro_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paciente ADD CONSTRAINT FK_C6CBA95EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE paciente ADD CONSTRAINT FK_C6CBA95EDB85E3A0 FOREIGN KEY (seguro_id) REFERENCES seguro_medico (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C6CBA95EA76ED395 ON paciente (user_id)');
        $this->addSql('CREATE INDEX IDX_C6CBA95EDB85E3A0 ON paciente (seguro_id)');
        $this->addSql('ALTER TABLE prescripcion ADD paciente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prescripcion ADD CONSTRAINT FK_D271D7FF7310DAD4 FOREIGN KEY (paciente_id) REFERENCES paciente (id)');
        $this->addSql('CREATE INDEX IDX_D271D7FF7310DAD4 ON prescripcion (paciente_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE7310DAD4');
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDEA9276E6C');
        $this->addSql('DROP INDEX IDX_A6FE3FDE7310DAD4 ON consulta');
        $this->addSql('DROP INDEX IDX_A6FE3FDEA9276E6C ON consulta');
        $this->addSql('ALTER TABLE consulta DROP paciente_id, DROP tipo_id');
        $this->addSql('ALTER TABLE paciente DROP FOREIGN KEY FK_C6CBA95EA76ED395');
        $this->addSql('ALTER TABLE paciente DROP FOREIGN KEY FK_C6CBA95EDB85E3A0');
        $this->addSql('DROP INDEX UNIQ_C6CBA95EA76ED395 ON paciente');
        $this->addSql('DROP INDEX IDX_C6CBA95EDB85E3A0 ON paciente');
        $this->addSql('ALTER TABLE paciente DROP user_id, DROP seguro_id');
        $this->addSql('ALTER TABLE prescripcion DROP FOREIGN KEY FK_D271D7FF7310DAD4');
        $this->addSql('DROP INDEX IDX_D271D7FF7310DAD4 ON prescripcion');
        $this->addSql('ALTER TABLE prescripcion DROP paciente_id');
    }
}
