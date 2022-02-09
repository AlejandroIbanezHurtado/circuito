<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207113359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detalle_reserva (id INT AUTO_INCREMENT NOT NULL, coche_id INT NOT NULL, INDEX IDX_5053C093F4621E56 (coche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserva (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, fecha DATETIME NOT NULL, precio DOUBLE PRECISION NOT NULL, fecha_inicio DATETIME NOT NULL, fecha_fin DATETIME DEFAULT NULL, INDEX IDX_188D2E3BDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valoracion_circuito (id INT AUTO_INCREMENT NOT NULL, reserva_id INT DEFAULT NULL, valoracion INT NOT NULL, comentario VARCHAR(300) DEFAULT NULL, UNIQUE INDEX UNIQ_2B7D9AEBD67139E8 (reserva_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valoracion_coche (id INT AUTO_INCREMENT NOT NULL, detalle_reserva_id INT DEFAULT NULL, valoracion INT NOT NULL, comentario VARCHAR(300) DEFAULT NULL, UNIQUE INDEX UNIQ_CF391497A08C14C9 (detalle_reserva_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detalle_reserva ADD CONSTRAINT FK_5053C093F4621E56 FOREIGN KEY (coche_id) REFERENCES coche (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE valoracion_circuito ADD CONSTRAINT FK_2B7D9AEBD67139E8 FOREIGN KEY (reserva_id) REFERENCES reserva (id)');
        $this->addSql('ALTER TABLE valoracion_coche ADD CONSTRAINT FK_CF391497A08C14C9 FOREIGN KEY (detalle_reserva_id) REFERENCES detalle_reserva (id)');
        $this->addSql('ALTER TABLE usuario ADD nombre VARCHAR(30) NOT NULL, ADD apellidos VARCHAR(70) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE valoracion_coche DROP FOREIGN KEY FK_CF391497A08C14C9');
        $this->addSql('ALTER TABLE valoracion_circuito DROP FOREIGN KEY FK_2B7D9AEBD67139E8');
        $this->addSql('DROP TABLE detalle_reserva');
        $this->addSql('DROP TABLE reserva');
        $this->addSql('DROP TABLE valoracion_circuito');
        $this->addSql('DROP TABLE valoracion_coche');
        $this->addSql('ALTER TABLE marca CHANGE nombre nombre VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE modelo CHANGE nombre nombre VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE usuario DROP nombre, DROP apellidos, CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
