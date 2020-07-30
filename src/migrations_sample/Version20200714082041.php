<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200714082041 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE fos_user ADD phone VARCHAR(25) DEFAULT NULL, ADD ssn VARCHAR(150) DEFAULT NULL, ADD vetran TINYINT(1) DEFAULT \'0\' NOT NULL, ADD ethinicity VARCHAR(150) DEFAULT NULL, ADD date_of_birth DATE DEFAULT NULL, ADD gender VARCHAR(10) DEFAULT NULL, ADD emergency_contact_person VARCHAR(75) DEFAULT NULL, ADD emergency_contact_phone VARCHAR(25) DEFAULT NULL, ADD address1 VARCHAR(150) DEFAULT NULL, ADD address2 VARCHAR(150) DEFAULT NULL, ADD city VARCHAR(75) DEFAULT NULL, ADD state VARCHAR(75) DEFAULT NULL, ADD zip VARCHAR(75) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

     
        $this->addSql('ALTER TABLE fos_user DROP phone, DROP ssn, DROP vetran, DROP ethinicity, DROP date_of_birth, DROP gender, DROP emergency_contact_person, DROP emergency_contact_phone, DROP address1, DROP address2, DROP city, DROP state, DROP zip');
    }
}
