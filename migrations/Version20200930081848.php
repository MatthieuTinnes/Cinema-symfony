<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200930081848 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('DROP INDEX IDX_1D5EF26F139504F0');
        $this->addSql('DROP INDEX IDX_1D5EF26F12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, realisator_id, category_id, title, release_date, description, slug, image_path FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, realisator_id INTEGER DEFAULT NULL, category_id INTEGER DEFAULT NULL, title VARCHAR(255) DEFAULT NULL COLLATE BINARY, release_date DATE DEFAULT NULL, description VARCHAR(255) DEFAULT NULL COLLATE BINARY, slug VARCHAR(255) DEFAULT NULL COLLATE BINARY, image_path VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_1D5EF26F139504F0 FOREIGN KEY (realisator_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1D5EF26F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO movie (id, realisator_id, category_id, title, release_date, description, slug, image_path) SELECT id, realisator_id, category_id, title, release_date, description, slug, image_path FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
        $this->addSql('CREATE INDEX IDX_1D5EF26F139504F0 ON movie (realisator_id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26F12469DE2 ON movie (category_id)');
        $this->addSql('DROP INDEX IDX_CD1B4C038F93B6FC');
        $this->addSql('DROP INDEX IDX_CD1B4C03217BBB47');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie_person AS SELECT movie_id, person_id FROM movie_person');
        $this->addSql('DROP TABLE movie_person');
        $this->addSql('CREATE TABLE movie_person (movie_id INTEGER NOT NULL, person_id INTEGER NOT NULL, PRIMARY KEY(movie_id, person_id), CONSTRAINT FK_CD1B4C038F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CD1B4C03217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO movie_person (movie_id, person_id) SELECT movie_id, person_id FROM __temp__movie_person');
        $this->addSql('DROP TABLE __temp__movie_person');
        $this->addSql('CREATE INDEX IDX_CD1B4C038F93B6FC ON movie_person (movie_id)');
        $this->addSql('CREATE INDEX IDX_CD1B4C03217BBB47 ON movie_person (person_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_1D5EF26F139504F0');
        $this->addSql('DROP INDEX IDX_1D5EF26F12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, realisator_id, category_id, title, release_date, description, image_path, slug FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, realisator_id INTEGER DEFAULT NULL, category_id INTEGER DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, release_date DATE DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, image_path VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO movie (id, realisator_id, category_id, title, release_date, description, image_path, slug) SELECT id, realisator_id, category_id, title, release_date, description, image_path, slug FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
        $this->addSql('CREATE INDEX IDX_1D5EF26F139504F0 ON movie (realisator_id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26F12469DE2 ON movie (category_id)');
        $this->addSql('DROP INDEX IDX_CD1B4C038F93B6FC');
        $this->addSql('DROP INDEX IDX_CD1B4C03217BBB47');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie_person AS SELECT movie_id, person_id FROM movie_person');
        $this->addSql('DROP TABLE movie_person');
        $this->addSql('CREATE TABLE movie_person (movie_id INTEGER NOT NULL, person_id INTEGER NOT NULL, PRIMARY KEY(movie_id, person_id))');
        $this->addSql('INSERT INTO movie_person (movie_id, person_id) SELECT movie_id, person_id FROM __temp__movie_person');
        $this->addSql('DROP TABLE __temp__movie_person');
        $this->addSql('CREATE INDEX IDX_CD1B4C038F93B6FC ON movie_person (movie_id)');
        $this->addSql('CREATE INDEX IDX_CD1B4C03217BBB47 ON movie_person (person_id)');
    }
}
