<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190923230916 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE race_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE horse_race_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE horse_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE race (id INT NOT NULL, active INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, completed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, duration DOUBLE PRECISION DEFAULT NULL, max_distance DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN race.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN race.completed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE horse_race (id INT NOT NULL, horse_id INT NOT NULL, race_id INT NOT NULL, time_spent DOUBLE PRECISION NOT NULL, distance_covered DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_88C49C9C76B275AD ON horse_race (horse_id)');
        $this->addSql('CREATE INDEX IDX_88C49C9C6E59D40D ON horse_race (race_id)');
        $this->addSql('CREATE TABLE horse (id INT NOT NULL, speed DOUBLE PRECISION NOT NULL, strength DOUBLE PRECISION NOT NULL, endurance DOUBLE PRECISION NOT NULL, best_speed DOUBLE PRECISION NOT NULL, autonomy DOUBLE PRECISION NOT NULL, slow_down DOUBLE PRECISION NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE horse_race ADD CONSTRAINT FK_88C49C9C76B275AD FOREIGN KEY (horse_id) REFERENCES horse (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE horse_race ADD CONSTRAINT FK_88C49C9C6E59D40D FOREIGN KEY (race_id) REFERENCES race (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE horse_race DROP CONSTRAINT FK_88C49C9C6E59D40D');
        $this->addSql('ALTER TABLE horse_race DROP CONSTRAINT FK_88C49C9C76B275AD');
        $this->addSql('DROP SEQUENCE race_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE horse_race_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE horse_id_seq CASCADE');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE horse_race');
        $this->addSql('DROP TABLE horse');
    }
}
