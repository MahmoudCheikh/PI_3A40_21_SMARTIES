<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220210133534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, type VARCHAR(255) NOT NULL, dated DATE NOT NULL, datef DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_351268BB79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accessoire (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE achat (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_produit_id INT NOT NULL, date DATE NOT NULL, nom_client VARCHAR(255) NOT NULL, numero_client INT NOT NULL, INDEX IDX_26A9845679F37AE5 (id_user_id), INDEX IDX_26A98456AABEFE2C (id_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, id_evenement_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_B87555152C115A61 (id_evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_produit_id INT NOT NULL, nb_produits INT NOT NULL, INDEX IDX_6EEAA67D79F37AE5 (id_user_id), INDEX IDX_6EEAA67DAABEFE2C (id_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emplacement (id INT AUTO_INCREMENT NOT NULL, lieu VARCHAR(255) NOT NULL, capacite INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date_d DATE NOT NULL, date_f DATE NOT NULL, lieu VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, nb_participants INT DEFAULT NULL, nb_places INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, duree DOUBLE PRECISION NOT NULL, INDEX IDX_5E9E89CB79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance (id INT AUTO_INCREMENT NOT NULL, id_velo_id INT NOT NULL, INDEX IDX_2F84F8E932F76CCD (id_velo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_sujet_id INT NOT NULL, date DATE NOT NULL, contenu VARCHAR(255) NOT NULL, INDEX IDX_B6BD307F79F37AE5 (id_user_id), INDEX IDX_B6BD307F2C96A5EB (id_sujet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece_dr (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, quantite INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, description VARCHAR(255) NOT NULL, date DATE NOT NULL, objet VARCHAR(255) NOT NULL, INDEX IDX_CE60640479F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, id_produit_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite INT NOT NULL, disponibilite VARCHAR(255) NOT NULL, INDEX IDX_4B365660AABEFE2C (id_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sujet (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_post INT NOT NULL, date DATE NOT NULL, titre VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, INDEX IDX_2E13599D79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE velo (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, age INT NOT NULL, couleur VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, quantite INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BB79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A9845679F37AE5 FOREIGN KEY (id_user_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456AABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555152C115A61 FOREIGN KEY (id_evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DAABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E932F76CCD FOREIGN KEY (id_velo_id) REFERENCES velo (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2C96A5EB FOREIGN KEY (id_sujet_id) REFERENCES sujet (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE60640479F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660AABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE sujet ADD CONSTRAINT FK_2E13599D79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A9845679F37AE5');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B87555152C115A61');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456AABEFE2C');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DAABEFE2C');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660AABEFE2C');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2C96A5EB');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BB79F37AE5');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D79F37AE5');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB79F37AE5');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F79F37AE5');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE60640479F37AE5');
        $this->addSql('ALTER TABLE sujet DROP FOREIGN KEY FK_2E13599D79F37AE5');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E932F76CCD');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE accessoire');
        $this->addSql('DROP TABLE achat');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE emplacement');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE piece_dr');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE sujet');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE velo');
    }
}
