<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231115224849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bag (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE engagement (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, organization_id INT NOT NULL, bag_id INT NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_D86F0141217BBB47 (person_id), INDEX IDX_D86F014132C8A3DE (organization_id), INDEX IDX_D86F01416F5D8297 (bag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, bag_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1F1B251E5E237E06 (name), INDEX IDX_1F1B251E6F5D8297 (bag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_C1EE637C77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE engagement ADD CONSTRAINT FK_D86F0141217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE engagement ADD CONSTRAINT FK_D86F014132C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE engagement ADD CONSTRAINT FK_D86F01416F5D8297 FOREIGN KEY (bag_id) REFERENCES bag (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E6F5D8297 FOREIGN KEY (bag_id) REFERENCES bag (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE engagement DROP FOREIGN KEY FK_D86F0141217BBB47');
        $this->addSql('ALTER TABLE engagement DROP FOREIGN KEY FK_D86F014132C8A3DE');
        $this->addSql('ALTER TABLE engagement DROP FOREIGN KEY FK_D86F01416F5D8297');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E6F5D8297');
        $this->addSql('DROP TABLE bag');
        $this->addSql('DROP TABLE engagement');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE person');
    }
}
