<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220107153336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC4BEA1ED6');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C4BEA1ED6');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCDBDD131C');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, idtrick INT DEFAULT NULL, iduser INT DEFAULT NULL, content VARCHAR(1000) NOT NULL, date DATE NOT NULL, valid INT NOT NULL, INDEX idtrick (idtrick), INDEX iduser (iduser), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(10000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, nickname VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(200) NOT NULL, active INT NOT NULL, type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CEF5C507 FOREIGN KEY (idtrick) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5E5C27E9 FOREIGN KEY (iduser) REFERENCES user (id)');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE figure');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP INDEX idfigure ON media');
        $this->addSql('ALTER TABLE media CHANGE idfigure idtrick INT DEFAULT NULL, CHANGE estprincipal ismain INT NOT NULL, CHANGE nom name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CEF5C507 FOREIGN KEY (idtrick) REFERENCES trick (id)');
        $this->addSql('CREATE INDEX idtrick ON media (idtrick)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CEF5C507');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CEF5C507');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5E5C27E9');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, idfigure INT DEFAULT NULL, idutilisateur INT DEFAULT NULL, contenu VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, valide INT NOT NULL, INDEX idfigure (idfigure), INDEX idutilisateur (idutilisateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE figure (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(10000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, identifiant VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, motdepasse VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, actif INT NOT NULL, type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC4BEA1ED6 FOREIGN KEY (idfigure) REFERENCES figure (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCDBDD131C FOREIGN KEY (idutilisateur) REFERENCES utilisateur (id)');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE trick');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX idtrick ON media');
        $this->addSql('ALTER TABLE media CHANGE idtrick idfigure INT DEFAULT NULL, CHANGE ismain estprincipal INT NOT NULL, CHANGE name nom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C4BEA1ED6 FOREIGN KEY (idfigure) REFERENCES figure (id)');
        $this->addSql('CREATE INDEX idfigure ON media (idfigure)');
    }
}
