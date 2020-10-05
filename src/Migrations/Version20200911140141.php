<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200911140141 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sym_api_admin_user_master.fos_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_4B019DDB5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sym_api_admin_user_master.user (id INT AUTO_INCREMENT NOT NULL, institution_email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, prefix VARCHAR(20) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, institution_name VARCHAR(150) NOT NULL, reference_id INT NOT NULL, UNIQUE INDEX UNIQ_8D93D64968AE7BC (institution_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sym_api_admin_user_master.fos_entity_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(75) NOT NULL, label VARCHAR(75) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sym_api_admin_user_master.group_entitities (id INT AUTO_INCREMENT NOT NULL, entitygroup_id INT DEFAULT NULL, group_id INT DEFAULT NULL, name VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_D750287119D10A19 (entitygroup_id), INDEX IDX_D7502871FE54D947 (group_id), UNIQUE INDEX UNIQ_D75028715E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sym_api_admin_user_master.fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, prefix VARCHAR(20) NOT NULL, institution_name VARCHAR(150) NOT NULL, phone VARCHAR(25) DEFAULT NULL, ssn VARCHAR(150) DEFAULT NULL, vetran VARCHAR(150) DEFAULT NULL, ethinicity VARCHAR(150) DEFAULT NULL, date_of_birth DATE DEFAULT NULL, gender VARCHAR(10) DEFAULT NULL, emergency_contact_person VARCHAR(75) DEFAULT NULL, emergency_contact_phone VARCHAR(25) DEFAULT NULL, address1 VARCHAR(150) DEFAULT NULL, address2 VARCHAR(150) DEFAULT NULL, city VARCHAR(75) DEFAULT NULL, state VARCHAR(75) DEFAULT NULL, zip VARCHAR(75) DEFAULT NULL, middle_name VARCHAR(100) DEFAULT NULL, position VARCHAR(150) DEFAULT NULL, dummy_password VARCHAR(150) DEFAULT NULL, institution_profile_code VARCHAR(150) DEFAULT NULL, local_fos_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sym_api_admin_user_master.fos_user_user_group (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_5809D6ADA76ED395 (user_id), INDEX IDX_5809D6ADFE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sym_api_admin_user_master.group_entitities ADD CONSTRAINT FK_DA35D60C19D10A19 FOREIGN KEY (entitygroup_id) REFERENCES sym_api_admin_user_master.fos_entity_group (id)');
        $this->addSql('ALTER TABLE sym_api_admin_user_master.group_entitities ADD CONSTRAINT FK_DA35D60CFE54D947 FOREIGN KEY (group_id) REFERENCES sym_api_admin_user_master.fos_group (id)');
        $this->addSql('ALTER TABLE sym_api_admin_user_master.fos_user_user_group ADD CONSTRAINT FK_5809D6ADA76ED395 FOREIGN KEY (user_id) REFERENCES sym_api_admin_user_master.fos_user (id)');
        $this->addSql('ALTER TABLE sym_api_admin_user_master.fos_user_user_group ADD CONSTRAINT FK_5809D6ADFE54D947 FOREIGN KEY (group_id) REFERENCES sym_api_admin_user_master.fos_group (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sym_api_admin_user_master.fos_user');
        $this->addSql('DROP TABLE sym_api_admin_user_master.fos_user_user_group');
        $this->addSql('DROP TABLE sym_api_admin_user_master.fos_entity_group');
        $this->addSql('DROP TABLE sym_api_admin_user_master.user');
        $this->addSql('DROP TABLE sym_api_admin_user_master.group_entitities');
        $this->addSql('DROP TABLE sym_api_admin_user_master.fos_group');
    }
}
