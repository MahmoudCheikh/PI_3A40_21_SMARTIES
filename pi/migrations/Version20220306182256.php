<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220306182256 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_event_id INT NOT NULL, INDEX IDX_AB55E24F79F37AE5 (id_user_id), INDEX IDX_AB55E24F212C041E (id_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F212C041E FOREIGN KEY (id_event_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE favoris ADD id_user_id INT NOT NULL, CHANGE id_produit_id id_produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43279F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_8933C43279F37AE5 ON favoris (id_user_id)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E951E8871B');
        $this->addSql('DROP INDEX IDX_1483A5E951E8871B ON users');
        $this->addSql('ALTER TABLE users DROP favoris_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE participation');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C43279F37AE5');
        $this->addSql('DROP INDEX IDX_8933C43279F37AE5 ON favoris');
        $this->addSql('ALTER TABLE favoris DROP id_user_id, CHANGE id_produit_id id_produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD favoris_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E951E8871B FOREIGN KEY (favoris_id) REFERENCES favoris (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E951E8871B ON users (favoris_id)');
    }
}
