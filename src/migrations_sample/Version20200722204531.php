<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722204531 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE institution_academic_details (id INT AUTO_INCREMENT NOT NULL, term VARCHAR(150) DEFAULT NULL, academic_year VARCHAR(11) DEFAULT NULL, associate_degrees VARCHAR(11) DEFAULT NULL, bachelors_degrees VARCHAR(11) DEFAULT NULL, master_degrees VARCHAR(11) DEFAULT NULL, doctorate_degrees VARCHAR(11) DEFAULT NULL, under_graduate VARCHAR(11) DEFAULT NULL, graduate VARCHAR(11) DEFAULT NULL, year VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_accrediation (id INT AUTO_INCREMENT NOT NULL, ins_profile_id INT DEFAULT NULL, accrediation VARCHAR(255) DEFAULT NULL, INDEX IDX_D4FEB57690C7DF68 (ins_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_college_schools (id INT AUTO_INCREMENT NOT NULL, ins_profile_id INT DEFAULT NULL, college_school_name VARCHAR(150) DEFAULT NULL, INDEX IDX_9C8BA45C90C7DF68 (ins_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_contact_info (id INT AUTO_INCREMENT NOT NULL, office_number VARCHAR(50) DEFAULT NULL, mailing_name VARCHAR(75) DEFAULT NULL, fax_number VARCHAR(75) DEFAULT NULL, department VARCHAR(150) DEFAULT NULL, website VARCHAR(150) DEFAULT NULL, email VARCHAR(150) DEFAULT NULL, address1 VARCHAR(150) DEFAULT NULL, address2 VARCHAR(150) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, state VARCHAR(25) DEFAULT NULL, postal_code VARCHAR(25) DEFAULT NULL, new VARCHAR(75) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_degrees (id INT AUTO_INCREMENT NOT NULL, ins_profile_id INT DEFAULT NULL, degree_name VARCHAR(255) DEFAULT NULL, INDEX IDX_ABECAA1690C7DF68 (ins_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_faculty_details (id INT AUTO_INCREMENT NOT NULL, term VARCHAR(150) DEFAULT NULL, year VARCHAR(5) DEFAULT NULL, full_time_faculty VARCHAR(11) DEFAULT NULL, student_faculty_ratio VARCHAR(4) DEFAULT NULL, faculty_higher_degree VARCHAR(11) DEFAULT NULL, avg_ugclass_size VARCHAR(11) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_location_info (id INT AUTO_INCREMENT NOT NULL, address1 VARCHAR(150) DEFAULT NULL, address2 VARCHAR(150) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, state VARCHAR(25) DEFAULT NULL, postal_code VARCHAR(25) DEFAULT NULL, region VARCHAR(150) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_profile (id INT AUTO_INCREMENT NOT NULL, institution_contact_id INT DEFAULT NULL, institution_location_id INT DEFAULT NULL, student_det_id INT DEFAULT NULL, faculty_det_id INT DEFAULT NULL, academic_det_id INT DEFAULT NULL, institution_name VARCHAR(150) DEFAULT NULL, campus_name VARCHAR(150) DEFAULT NULL, ins_profile_image VARCHAR(255) DEFAULT NULL, founded VARCHAR(75) DEFAULT NULL, ins_type VARCHAR(50) DEFAULT NULL, language VARCHAR(25) DEFAULT NULL, president VARCHAR(75) DEFAULT NULL, academic_calendar VARCHAR(50) DEFAULT NULL, other_languages VARCHAR(50) DEFAULT NULL, total_employees INT DEFAULT NULL, alumini VARCHAR(11) DEFAULT NULL, overview LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_E5A95C9D1D5D090 (institution_contact_id), UNIQUE INDEX UNIQ_E5A95C9D60AD6EB1 (institution_location_id), UNIQUE INDEX UNIQ_E5A95C9D801EE7BB (student_det_id), UNIQUE INDEX UNIQ_E5A95C9D19840590 (faculty_det_id), UNIQUE INDEX UNIQ_E5A95C9DE5D24169 (academic_det_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_recognition (id INT AUTO_INCREMENT NOT NULL, ins_profile_id INT DEFAULT NULL, recognition VARCHAR(255) DEFAULT NULL, INDEX IDX_F33B208D90C7DF68 (ins_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_student_details (id INT AUTO_INCREMENT NOT NULL, term VARCHAR(50) DEFAULT NULL, year VARCHAR(5) DEFAULT NULL, total_students VARCHAR(11) DEFAULT NULL, female_students VARCHAR(11) DEFAULT NULL, male_students VARCHAR(11) DEFAULT NULL, undergrad_students VARCHAR(11) DEFAULT NULL, grad_students VARCHAR(11) DEFAULT NULL, other_students VARCHAR(11) DEFAULT NULL, full_time_students VARCHAR(11) DEFAULT NULL, in_state_students VARCHAR(11) DEFAULT NULL, out_of_state_students VARCHAR(11) DEFAULT NULL, part_time_students VARCHAR(11) DEFAULT NULL, inter_national_students VARCHAR(11) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_media_urls (id INT AUTO_INCREMENT NOT NULL, ins_profile_id INT DEFAULT NULL, social_media VARCHAR(25) NOT NULL, url LONGTEXT NOT NULL, INDEX IDX_27805AB090C7DF68 (ins_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE institution_accrediation ADD CONSTRAINT FK_D4FEB57690C7DF68 FOREIGN KEY (ins_profile_id) REFERENCES institution_profile (id)');
        $this->addSql('ALTER TABLE institution_college_schools ADD CONSTRAINT FK_9C8BA45C90C7DF68 FOREIGN KEY (ins_profile_id) REFERENCES institution_profile (id)');
        $this->addSql('ALTER TABLE institution_degrees ADD CONSTRAINT FK_ABECAA1690C7DF68 FOREIGN KEY (ins_profile_id) REFERENCES institution_profile (id)');
        $this->addSql('ALTER TABLE institution_profile ADD CONSTRAINT FK_E5A95C9D1D5D090 FOREIGN KEY (institution_contact_id) REFERENCES institution_contact_info (id)');
        $this->addSql('ALTER TABLE institution_profile ADD CONSTRAINT FK_E5A95C9D60AD6EB1 FOREIGN KEY (institution_location_id) REFERENCES institution_location_info (id)');
        $this->addSql('ALTER TABLE institution_profile ADD CONSTRAINT FK_E5A95C9D801EE7BB FOREIGN KEY (student_det_id) REFERENCES institution_student_details (id)');
        $this->addSql('ALTER TABLE institution_profile ADD CONSTRAINT FK_E5A95C9D19840590 FOREIGN KEY (faculty_det_id) REFERENCES institution_faculty_details (id)');
        $this->addSql('ALTER TABLE institution_profile ADD CONSTRAINT FK_E5A95C9DE5D24169 FOREIGN KEY (academic_det_id) REFERENCES institution_academic_details (id)');
        $this->addSql('ALTER TABLE institution_recognition ADD CONSTRAINT FK_F33B208D90C7DF68 FOREIGN KEY (ins_profile_id) REFERENCES institution_profile (id)');
        $this->addSql('ALTER TABLE social_media_urls ADD CONSTRAINT FK_27805AB090C7DF68 FOREIGN KEY (ins_profile_id) REFERENCES institution_profile (id)');
       
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE institution_profile DROP FOREIGN KEY FK_E5A95C9DE5D24169');
        $this->addSql('ALTER TABLE institution_profile DROP FOREIGN KEY FK_E5A95C9D1D5D090');
        $this->addSql('ALTER TABLE institution_profile DROP FOREIGN KEY FK_E5A95C9D19840590');
        $this->addSql('ALTER TABLE institution_profile DROP FOREIGN KEY FK_E5A95C9D60AD6EB1');
        $this->addSql('ALTER TABLE institution_accrediation DROP FOREIGN KEY FK_D4FEB57690C7DF68');
        $this->addSql('ALTER TABLE institution_college_schools DROP FOREIGN KEY FK_9C8BA45C90C7DF68');
        $this->addSql('ALTER TABLE institution_degrees DROP FOREIGN KEY FK_ABECAA1690C7DF68');
        $this->addSql('ALTER TABLE institution_recognition DROP FOREIGN KEY FK_F33B208D90C7DF68');
        $this->addSql('ALTER TABLE social_media_urls DROP FOREIGN KEY FK_27805AB090C7DF68');
        $this->addSql('ALTER TABLE institution_profile DROP FOREIGN KEY FK_E5A95C9D801EE7BB');
        $this->addSql('DROP TABLE institution_academic_details');
        $this->addSql('DROP TABLE institution_accrediation');
        $this->addSql('DROP TABLE institution_college_schools');
        $this->addSql('DROP TABLE institution_contact_info');
        $this->addSql('DROP TABLE institution_degrees');
        $this->addSql('DROP TABLE institution_faculty_details');
        $this->addSql('DROP TABLE institution_location_info');
        $this->addSql('DROP TABLE institution_profile');
        $this->addSql('DROP TABLE institution_recognition');
        $this->addSql('DROP TABLE institution_student_details');
        $this->addSql('DROP TABLE social_media_urls');
    }
}
