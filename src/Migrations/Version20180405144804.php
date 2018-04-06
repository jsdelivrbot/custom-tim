<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180405144804 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tim_rule_zone DROP FOREIGN KEY FK_6BB8B2D744E0351');
        $this->addSql('CREATE TABLE regle (id INT AUTO_INCREMENT NOT NULL, tag_id INT NOT NULL, yes_id INT NOT NULL, INDEX IDX_F0C02F5ABAD26311 (tag_id), INDEX IDX_F0C02F5A2CB716C7 (yes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regle_zone (regle_id INT NOT NULL, zone_id INT NOT NULL, INDEX IDX_F22FAFE38E12947B (regle_id), INDEX IDX_F22FAFE39F2C3FAB (zone_id), PRIMARY KEY(regle_id, zone_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE regle ADD CONSTRAINT FK_F0C02F5ABAD26311 FOREIGN KEY (tag_id) REFERENCES tim_tag (id)');
        $this->addSql('ALTER TABLE regle ADD CONSTRAINT FK_F0C02F5A2CB716C7 FOREIGN KEY (yes_id) REFERENCES tim_status (id)');
        $this->addSql('ALTER TABLE regle_zone ADD CONSTRAINT FK_F22FAFE38E12947B FOREIGN KEY (regle_id) REFERENCES regle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE regle_zone ADD CONSTRAINT FK_F22FAFE39F2C3FAB FOREIGN KEY (zone_id) REFERENCES tim_zone (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE tim_rule');
        $this->addSql('DROP TABLE tim_rule_zone');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE regle_zone DROP FOREIGN KEY FK_F22FAFE38E12947B');
        $this->addSql('CREATE TABLE tim_rule (id INT AUTO_INCREMENT NOT NULL, tag_id INT NOT NULL, status_id INT NOT NULL, INDEX IDX_3AA37E7BBAD26311 (tag_id), INDEX IDX_3AA37E7B6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tim_rule_zone (rule_id INT NOT NULL, zone_id INT NOT NULL, UNIQUE INDEX UNIQ_6BB8B2D9F2C3FAB (zone_id), INDEX IDX_6BB8B2D744E0351 (rule_id), PRIMARY KEY(rule_id, zone_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tim_rule ADD CONSTRAINT FK_3AA37E7B6BF700BD FOREIGN KEY (status_id) REFERENCES tim_status (id)');
        $this->addSql('ALTER TABLE tim_rule ADD CONSTRAINT FK_3AA37E7BBAD26311 FOREIGN KEY (tag_id) REFERENCES tim_tag (id)');
        $this->addSql('ALTER TABLE tim_rule_zone ADD CONSTRAINT FK_6BB8B2D744E0351 FOREIGN KEY (rule_id) REFERENCES tim_rule (id)');
        $this->addSql('ALTER TABLE tim_rule_zone ADD CONSTRAINT FK_6BB8B2D9F2C3FAB FOREIGN KEY (zone_id) REFERENCES tim_zone (id)');
        $this->addSql('DROP TABLE regle');
        $this->addSql('DROP TABLE regle_zone');
    }
}
