<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180330125217 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE zone_rule_zone DROP FOREIGN KEY FK_7DB9CC05CA7A0069');
        $this->addSql('CREATE TABLE tim_rule_zone (rule_id INT NOT NULL, zone_id INT NOT NULL, INDEX IDX_6BB8B2D744E0351 (rule_id), UNIQUE INDEX UNIQ_6BB8B2D9F2C3FAB (zone_id), PRIMARY KEY(rule_id, zone_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tim_rule_zone ADD CONSTRAINT FK_6BB8B2D744E0351 FOREIGN KEY (rule_id) REFERENCES tim_rule (id)');
        $this->addSql('ALTER TABLE tim_rule_zone ADD CONSTRAINT FK_6BB8B2D9F2C3FAB FOREIGN KEY (zone_id) REFERENCES tim_zone (id)');
        $this->addSql('DROP TABLE tim_zone_rule');
        $this->addSql('DROP TABLE zone_rule_zone');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tim_zone_rule (id INT AUTO_INCREMENT NOT NULL, rule_id INT NOT NULL, INDEX IDX_21B47934744E0351 (rule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone_rule_zone (zone_rule_id INT NOT NULL, zone_id INT NOT NULL, INDEX IDX_7DB9CC05CA7A0069 (zone_rule_id), INDEX IDX_7DB9CC059F2C3FAB (zone_id), PRIMARY KEY(zone_rule_id, zone_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tim_zone_rule ADD CONSTRAINT FK_21B47934744E0351 FOREIGN KEY (rule_id) REFERENCES tim_rule (id)');
        $this->addSql('ALTER TABLE zone_rule_zone ADD CONSTRAINT FK_7DB9CC059F2C3FAB FOREIGN KEY (zone_id) REFERENCES tim_zone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zone_rule_zone ADD CONSTRAINT FK_7DB9CC05CA7A0069 FOREIGN KEY (zone_rule_id) REFERENCES tim_zone_rule (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE tim_rule_zone');
    }
}
