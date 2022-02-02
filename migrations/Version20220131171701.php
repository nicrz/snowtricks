<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131171701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5E5C27E9');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CEF5C507');
        $this->addSql('DROP INDEX idtrick ON comment');
        $this->addSql('DROP INDEX iduser ON comment');
        $this->addSql('ALTER TABLE comment ADD trick INT DEFAULT NULL, ADD user INT DEFAULT NULL, DROP idtrick, DROP iduser');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD8F0A91E FOREIGN KEY (trick) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX trick ON comment (trick)');
        $this->addSql('CREATE INDEX user ON comment (user)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CD8F0A91E');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8D93D649');
        $this->addSql('DROP INDEX trick ON comment');
        $this->addSql('DROP INDEX user ON comment');
        $this->addSql('ALTER TABLE comment ADD idtrick INT DEFAULT NULL, ADD iduser INT DEFAULT NULL, DROP trick, DROP user');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5E5C27E9 FOREIGN KEY (iduser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CEF5C507 FOREIGN KEY (idtrick) REFERENCES trick (id)');
        $this->addSql('CREATE INDEX idtrick ON comment (idtrick)');
        $this->addSql('CREATE INDEX iduser ON comment (iduser)');
    }
}
