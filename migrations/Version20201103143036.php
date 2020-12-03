<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103143036 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, numero INT NOT NULL, total INT NOT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_6EEAA67DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, prestation_id INT NOT NULL, user_id INT NOT NULL, transfert_id INT NOT NULL, note VARCHAR(50) DEFAULT NULL, contenu VARCHAR(255) DEFAULT NULL, INDEX IDX_67F068BC9E45C554 (prestation_id), INDEX IDX_67F068BCA76ED395 (user_id), INDEX IDX_67F068BC3C9C4BAD (transfert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_de_cmd (id INT AUTO_INCREMENT NOT NULL, prestation_id INT NOT NULL, commande_id INT NOT NULL, transfert_id INT NOT NULL, quantite INT NOT NULL, prix_unitaire INT NOT NULL, INDEX IDX_16DC52B29E45C554 (prestation_id), INDEX IDX_16DC52B282EA2E54 (commande_id), INDEX IDX_16DC52B23C9C4BAD (transfert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece_jointe (id INT AUTO_INCREMENT NOT NULL, prestation_id INT DEFAULT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_AB5111D49E45C554 (prestation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestation (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, destination VARCHAR(255) DEFAULT NULL, nb_passager INT DEFAULT NULL, nb_bagage INT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, prix INT DEFAULT NULL, dispo TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_51C88FADFF7747B4 (titre), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transfert (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, destination VARCHAR(255) DEFAULT NULL, nb_passager INT DEFAULT NULL, nb_bagage INT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, prix INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, dispo TINYINT(1) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, nom_complet VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC3C9C4BAD FOREIGN KEY (transfert_id) REFERENCES transfert (id)');
        $this->addSql('ALTER TABLE ligne_de_cmd ADD CONSTRAINT FK_16DC52B29E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE ligne_de_cmd ADD CONSTRAINT FK_16DC52B282EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_de_cmd ADD CONSTRAINT FK_16DC52B23C9C4BAD FOREIGN KEY (transfert_id) REFERENCES transfert (id)');
        $this->addSql('ALTER TABLE piece_jointe ADD CONSTRAINT FK_AB5111D49E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_de_cmd DROP FOREIGN KEY FK_16DC52B282EA2E54');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC9E45C554');
        $this->addSql('ALTER TABLE ligne_de_cmd DROP FOREIGN KEY FK_16DC52B29E45C554');
        $this->addSql('ALTER TABLE piece_jointe DROP FOREIGN KEY FK_AB5111D49E45C554');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC3C9C4BAD');
        $this->addSql('ALTER TABLE ligne_de_cmd DROP FOREIGN KEY FK_16DC52B23C9C4BAD');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE ligne_de_cmd');
        $this->addSql('DROP TABLE piece_jointe');
        $this->addSql('DROP TABLE prestation');
        $this->addSql('DROP TABLE transfert');
        $this->addSql('DROP TABLE user');
    }
}
