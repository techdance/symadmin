<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200716151130 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

      
        $this->addSql('ALTER TABLE fos_user CHANGE vetran vetran VARCHAR(150) DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_user CHANGE middle_name middle_name VARCHAR(100)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

      
        $this->addSql('ALTER TABLE fos_user CHANGE vetran vetran TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE fos_user CHANGE middle_name middle_name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
