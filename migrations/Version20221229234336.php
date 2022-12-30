<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221229234336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode CHANGE synopsis synopsis VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE Program DROP image');
        $this->addSql('ALTER TABLE season CHANGE description description VARCHAR(6000) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode CHANGE synopsis synopsis VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE program ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE season CHANGE description description VARCHAR(6000) NOT NULL');
    }
}
