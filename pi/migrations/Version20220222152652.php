<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222152652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emplacement ADD stock_id INT NOT NULL');
        $this->addSql('ALTER TABLE emplacement ADD CONSTRAINT FK_C0CF65F6DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_C0CF65F6DCD6110 ON emplacement (stock_id)');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E932F76CCD');
        $this->addSql('DROP INDEX IDX_2F84F8E932F76CCD ON maintenance');
        $this->addSql('ALTER TABLE maintenance ADD relation_id INT DEFAULT NULL, ADD reclamation_id INT NOT NULL, ADD date_debut DATE NOT NULL, ADD date_fin DATE NOT NULL, ADD adresse VARCHAR(255) NOT NULL, CHANGE id_velo_id id_produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E93256915B FOREIGN KEY (relation_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E9AABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E92D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('CREATE INDEX IDX_2F84F8E93256915B ON maintenance (relation_id)');
        $this->addSql('CREATE INDEX IDX_2F84F8E9AABEFE2C ON maintenance (id_produit_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F84F8E92D6BA2D9 ON maintenance (reclamation_id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2C96A5EB');
        $this->addSql('ALTER TABLE message CHANGE id_sujet_id id_sujet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2C96A5EB FOREIGN KEY (id_sujet_id) REFERENCES sujet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit ADD prix DOUBLE PRECISION NOT NULL, ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL, DROP id_user, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE achat CHANGE nom_client nom_client VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE activite CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE emplacement DROP FOREIGN KEY FK_C0CF65F6DCD6110');
        $this->addSql('DROP INDEX IDX_C0CF65F6DCD6110 ON emplacement');
        $this->addSql('ALTER TABLE emplacement DROP stock_id, CHANGE lieu lieu VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE evenement CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lieu lieu VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E93256915B');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E9AABEFE2C');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E92D6BA2D9');
        $this->addSql('DROP INDEX IDX_2F84F8E93256915B ON maintenance');
        $this->addSql('DROP INDEX IDX_2F84F8E9AABEFE2C ON maintenance');
        $this->addSql('DROP INDEX UNIQ_2F84F8E92D6BA2D9 ON maintenance');
        $this->addSql('ALTER TABLE maintenance ADD id_velo_id INT NOT NULL, DROP relation_id, DROP id_produit_id, DROP reclamation_id, DROP date_debut, DROP date_fin, DROP adresse');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E932F76CCD FOREIGN KEY (id_velo_id) REFERENCES velo (id)');
        $this->addSql('CREATE INDEX IDX_2F84F8E932F76CCD ON maintenance (id_velo_id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2C96A5EB');
        $this->addSql('ALTER TABLE message CHANGE id_sujet_id id_sujet_id INT NOT NULL, CHANGE contenu contenu VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2C96A5EB FOREIGN KEY (id_sujet_id) REFERENCES sujet (id)');
        $this->addSql('ALTER TABLE piece_dr CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE produit DROP prix, DROP type, CHANGE libelle libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reclamation CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE objet objet VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE stock CHANGE libelle libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE disponibilite disponibilite VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sujet CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contenu contenu VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_1483A5E9E7927C74 ON users');
        $this->addSql('ALTER TABLE users ADD id_user INT NOT NULL, DROP roles, DROP password, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse adresse VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE role role VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE velo CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE couleur couleur VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE etat etat VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
