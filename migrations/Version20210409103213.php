<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210409103213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE SEQUENCE race_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE horse_in_race_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE horse_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE race (id INT NOT NULL, active INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
                            completed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                            duration DOUBLE PRECISION DEFAULT NULL, max_distance DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE horse_in_race (id INT NOT NULL, horse_id INT NOT NULL, race_id INT NOT NULL, time_spent DOUBLE PRECISION NOT NULL, distance_covered DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4D38175576B275AD ON horse_in_race (horse_id)');
        $this->addSql('CREATE INDEX IDX_4D3817556E59D40D ON horse_in_race (race_id)');
        $this->addSql('CREATE TABLE horse (id INT NOT NULL, speed DOUBLE PRECISION NOT NULL, strength DOUBLE PRECISION NOT NULL, endurance DOUBLE PRECISION NOT NULL, best_speed DOUBLE PRECISION NOT NULL, autonomy DOUBLE PRECISION NOT NULL, slow_down DOUBLE PRECISION NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE horse_in_race ADD CONSTRAINT FK_4D38175576B275AD FOREIGN KEY (horse_id) REFERENCES horse (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE horse_in_race ADD CONSTRAINT FK_4D3817556E59D40D FOREIGN KEY (race_id) REFERENCES race (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('COMMENT ON COLUMN race.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN race.completed_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
