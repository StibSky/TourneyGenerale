<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526081651 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE match_tracker DROP FOREIGN KEY FK_DBC575C0B333A61F');
        $this->addSql('DROP INDEX IDX_DBC575C0B333A61F ON match_tracker');
        $this->addSql('ALTER TABLE match_tracker CHANGE home_teams_id home_team_id INT NOT NULL');
        $this->addSql('ALTER TABLE match_tracker ADD CONSTRAINT FK_DBC575C09C4C13F6 FOREIGN KEY (home_team_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_DBC575C09C4C13F6 ON match_tracker (home_team_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE match_tracker DROP FOREIGN KEY FK_DBC575C09C4C13F6');
        $this->addSql('DROP INDEX IDX_DBC575C09C4C13F6 ON match_tracker');
        $this->addSql('ALTER TABLE match_tracker CHANGE home_team_id home_teams_id INT NOT NULL');
        $this->addSql('ALTER TABLE match_tracker ADD CONSTRAINT FK_DBC575C0B333A61F FOREIGN KEY (home_teams_id) REFERENCES team (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DBC575C0B333A61F ON match_tracker (home_teams_id)');
    }
}
