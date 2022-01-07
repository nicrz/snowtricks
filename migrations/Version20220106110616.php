<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220106110616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, idfigure INT DEFAULT NULL, idutilisateur INT DEFAULT NULL, contenu VARCHAR(1000) NOT NULL, prenom VARCHAR(100) NOT NULL, date DATE NOT NULL, valide INT NOT NULL, INDEX idfigure (idfigure), INDEX idutilisateur (idutilisateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE figure (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, description VARCHAR(10000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, idfigure INT DEFAULT NULL, estprincipal INT NOT NULL, type INT NOT NULL, nom VARCHAR(100) NOT NULL, code VARCHAR(10000) DEFAULT NULL, INDEX idfigure (idfigure), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, identifiant VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, motdepasse VARCHAR(200) NOT NULL, actif INT NOT NULL, type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC4BEA1ED6 FOREIGN KEY (idfigure) REFERENCES figure (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCDBDD131C FOREIGN KEY (idutilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C4BEA1ED6 FOREIGN KEY (idfigure) REFERENCES figure (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC4BEA1ED6');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C4BEA1ED6');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCDBDD131C');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE figure');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE utilisateur');
    }
}
