<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200910133449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        //$this->addSql('DROP TABLE user');
        //$this->addSql('ALTER TABLE fos_user CHANGE middle_name middle_name VARCHAR(100) NOT NULL');
        //$this->addSql('ALTER TABLE settings ADD loginLogo VARCHAR(255) DEFAULT NULL, ADD adminDashboardLogo VARCHAR(255) DEFAULT NULL, ADD ssoLogin VARCHAR(255) DEFAULT NULL, ADD collaboratedDirectLogin VARCHAR(255) DEFAULT NULL, ADD sideNavigationMenu VARCHAR(255) DEFAULT NULL, ADD sideNavigationMenuCollapsed VARCHAR(255) DEFAULT NULL, DROP login_logo, DROP admin_dashboard_logo');
        //$this->addSql('ALTER TABLE form_value RENAME INDEX idx_1d7758345ff69b7d TO IDX_9E30FCF75FF69B7D');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, institution_email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prefix VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, first_name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, last_name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, institution_name VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, reference_id INT NOT NULL, UNIQUE INDEX UNIQ_8D93D64968AE7BC (institution_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE form_value RENAME INDEX idx_9e30fcf75ff69b7d TO IDX_1D7758345FF69B7D');
        $this->addSql('ALTER TABLE fos_user CHANGE middle_name middle_name VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE settings ADD login_logo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD admin_dashboard_logo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP loginLogo, DROP adminDashboardLogo, DROP ssoLogin, DROP collaboratedDirectLogin, DROP sideNavigationMenu, DROP sideNavigationMenuCollapsed');
    }
}
