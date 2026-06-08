<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426185514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

$this->addSql('CREATE TABLE moyen_station (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
$this->addSql('CREATE TABLE moyen_transport_station (moyen_transport_id INT NOT NULL, station_id INT NOT NULL, INDEX IDX_B9988DA13ED8D53F (moyen_transport_id), INDEX IDX_B9988DA121BDB235 (station_id), PRIMARY KEY(moyen_transport_id, station_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
$this->addSql('ALTER TABLE moyen_transport_station ADD CONSTRAINT FK_B9988DA13ED8D53F FOREIGN KEY (moyen_transport_id) REFERENCES moyen_transport (id) ON DELETE CASCADE');
$this->addSql('ALTER TABLE moyen_transport_station ADD CONSTRAINT FK_B9988DA121BDB235 FOREIGN KEY (station_id) REFERENCES station (id) ON DELETE CASCADE');
$this->addSql('ALTER TABLE accident DROP FOREIGN KEY voiture_accident');
$this->addSql('ALTER TABLE avis DROP FOREIGN KEY utilisateur_avis');
$this->addSql('ALTER TABLE avis DROP FOREIGN KEY voiture_avis');
$this->addSql('ALTER TABLE entreprise_partenaire DROP FOREIGN KEY utilisateur_entreprise');
$this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY garage_maintenance');
$this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY voiture_maintenance');
$this->addSql('ALTER TABLE materiel DROP FOREIGN KEY garage_materiel');
$this->addSql('ALTER TABLE reservation DROP FOREIGN KEY moy_reservation');
$this->addSql('ALTER TABLE reservation DROP FOREIGN KEY utilisateur_reservation');
$this->addSql('ALTER TABLE reservation DROP FOREIGN KEY voiture_reservation');
$this->addSql('ALTER TABLE voiture DROP FOREIGN KEY entreprise_voiture');
$this->addSql('ALTER TABLE voiture DROP FOREIGN KEY utilisateu_voiture');
$this->addSql('DROP TABLE accident');
$this->addSql('DROP TABLE avis');
$this->addSql('DROP TABLE entreprise_partenaire');
$this->addSql('DROP TABLE garage');
$this->addSql('DROP TABLE maintenance');
$this->addSql('DROP TABLE materiel');
$this->addSql('DROP TABLE reservation');
$this->addSql('DROP TABLE utilisateur');
$this->addSql('DROP TABLE voiture');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

         $this->addSql('CREATE TABLE accident (id INT AUTO_INCREMENT NOT NULL, id_voiture INT NOT NULL, type INT NOT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, lieu VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, INDEX id_voiture (id_voiture), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, id_voiture INT NOT NULL, id_client INT NOT NULL, commentaire VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, etoile INT NOT NULL, INDEX id_voiture (id_voiture), INDEX id_client (id_client), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('CREATE TABLE entreprise_partenaire (id INT AUTO_INCREMENT NOT NULL, id_admin INT NOT NULL, nom_entreprise VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, nom_admin VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, prenom_admin VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, nb_voiture INT NOT NULL, tel VARCHAR(12) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, matricule VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, login VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, mdp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, INDEX id_admin (id_admin), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('CREATE TABLE garage (id INT AUTO_INCREMENT NOT NULL, matricule_garage VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('CREATE TABLE maintenance (id INT AUTO_INCREMENT NOT NULL, id_voiture INT NOT NULL, id_garage INT NOT NULL, date_maintenance DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, type VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, INDEX id_voiture (id_voiture), INDEX id_garage (id_garage), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('CREATE TABLE materiel (id_garage INT NOT NULL, nom INT NOT NULL, INDEX id_garage (id_garage)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_client INT NOT NULL, id_voiture INT NOT NULL, id_moy INT NOT NULL, date_debut DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, date_fin DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX id_client (id_client), INDEX id_voiture (id_voiture), INDEX moy_reservation (id_moy), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(35) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, prenom VARCHAR(35) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, cin VARCHAR(12) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, date_naiss VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, num_permis VARCHAR(12) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, ville VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, num_tel VARCHAR(12) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, login VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, mdp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, photo_personel VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, photo_permis VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, role VARCHAR(12) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, id_entreprise_partenaire INT NOT NULL, id_utilisateur INT NOT NULL, marque VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, model VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, etat VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, couleur VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, etat_technique VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, matricule VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE utf8mb4_general_ci, date_circulation DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX id_voiture (id_utilisateur), INDEX id_entreprise_partenaire (id_entreprise_partenaire), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB COMMENT = \'\' ');
         $this->addSql('ALTER TABLE accident ADD CONSTRAINT voiture_accident FOREIGN KEY (id_voiture) REFERENCES voiture (id)');
         $this->addSql('ALTER TABLE avis ADD CONSTRAINT utilisateur_avis FOREIGN KEY (id_client) REFERENCES utilisateur (id)');
         $this->addSql('ALTER TABLE avis ADD CONSTRAINT voiture_avis FOREIGN KEY (id_voiture) REFERENCES voiture (id)');
         $this->addSql('ALTER TABLE entreprise_partenaire ADD CONSTRAINT utilisateur_entreprise FOREIGN KEY (id_admin) REFERENCES utilisateur (id)');
         $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT garage_maintenance FOREIGN KEY (id_garage) REFERENCES garage (id)');
         $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT voiture_maintenance FOREIGN KEY (id_voiture) REFERENCES voiture (id)');
         $this->addSql('ALTER TABLE materiel ADD CONSTRAINT garage_materiel FOREIGN KEY (id_garage) REFERENCES garage (id)');
         $this->addSql('ALTER TABLE reservation ADD CONSTRAINT moy_reservation FOREIGN KEY (id_moy) REFERENCES reservation (id)');
         $this->addSql('ALTER TABLE reservation ADD CONSTRAINT utilisateur_reservation FOREIGN KEY (id_client) REFERENCES utilisateur (id)');
         $this->addSql('ALTER TABLE reservation ADD CONSTRAINT voiture_reservation FOREIGN KEY (id_voiture) REFERENCES voiture (id)');
         $this->addSql('ALTER TABLE voiture ADD CONSTRAINT entreprise_voiture FOREIGN KEY (id_entreprise_partenaire) REFERENCES entreprise_partenaire (id)');
         $this->addSql('ALTER TABLE voiture ADD CONSTRAINT utilisateu_voiture FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
         $this->addSql('ALTER TABLE moyen_transport_station DROP FOREIGN KEY FK_B9988DA13ED8D53F');
         $this->addSql('ALTER TABLE moyen_transport_station DROP FOREIGN KEY FK_B9988DA121BDB235');
         $this->addSql('DROP TABLE moyen_station');
         $this->addSql('DROP TABLE moyen_transport_station');

        $this->addSql('DROP TABLE user');
    }
}
