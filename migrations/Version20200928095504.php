<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200928095504 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) DEFAULT NULL)');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, realisator_id INTEGER DEFAULT NULL, category_id INTEGER DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, release_date DATE DEFAULT NULL, description VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_1D5EF26F139504F0 ON movie (realisator_id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26F12469DE2 ON movie (category_id)');
        $this->addSql('CREATE TABLE movie_person (movie_id INTEGER NOT NULL, person_id INTEGER NOT NULL, PRIMARY KEY(movie_id, person_id))');
        $this->addSql('CREATE INDEX IDX_CD1B4C038F93B6FC ON movie_person (movie_id)');
        $this->addSql('CREATE INDEX IDX_CD1B4C03217BBB47 ON movie_person (person_id)');
        $this->addSql('CREATE TABLE person (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, last_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, biography VARCHAR(2000) DEFAULT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_person');
        $this->addSql('DROP TABLE person');
    }
}
