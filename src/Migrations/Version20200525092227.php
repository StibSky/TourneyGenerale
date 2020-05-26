<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200525092227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE match_tracker (id INT AUTO_INCREMENT NOT NULL, home_teams_id INT NOT NULL, away_team_id INT NOT NULL, is_match_played TINYINT(1) NOT NULL, INDEX IDX_DBC575C0B333A61F (home_teams_id), INDEX IDX_DBC575C045185D02 (away_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE match_tracker ADD CONSTRAINT FK_DBC575C0B333A61F FOREIGN KEY (home_teams_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE match_tracker ADD CONSTRAINT FK_DBC575C045185D02 FOREIGN KEY (away_team_id) REFERENCES team (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE match_tracker');
    }
}
