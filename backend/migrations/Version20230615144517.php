<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615144517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE masterclass_composer DROP FOREIGN KEY FK_E78582C7A8D2620');
        $this->addSql('ALTER TABLE masterclass_composer DROP FOREIGN KEY FK_E78582C426F0705');
        $this->addSql('DROP TABLE masterclass_composer');
        $this->addSql('ALTER TABLE masterclass ADD composer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE masterclass ADD CONSTRAINT FK_9BDB44ED7A8D2620 FOREIGN KEY (composer_id) REFERENCES composer (id)');
        $this->addSql('CREATE INDEX IDX_9BDB44ED7A8D2620 ON masterclass (composer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE masterclass_composer (masterclass_id INT NOT NULL, composer_id INT NOT NULL, INDEX IDX_E78582C7A8D2620 (composer_id), INDEX IDX_E78582C426F0705 (masterclass_id), PRIMARY KEY(masterclass_id, composer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE masterclass_composer ADD CONSTRAINT FK_E78582C7A8D2620 FOREIGN KEY (composer_id) REFERENCES composer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE masterclass_composer ADD CONSTRAINT FK_E78582C426F0705 FOREIGN KEY (masterclass_id) REFERENCES masterclass (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE masterclass DROP FOREIGN KEY FK_9BDB44ED7A8D2620');
        $this->addSql('DROP INDEX IDX_9BDB44ED7A8D2620 ON masterclass');
        $this->addSql('ALTER TABLE masterclass DROP composer_id');
    }
}
