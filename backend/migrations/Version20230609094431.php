<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230609094431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8426F0705');
        $this->addSql('DROP INDEX IDX_987306D8426F0705 ON composer');
        $this->addSql('ALTER TABLE composer DROP masterclass_id');
        $this->addSql('ALTER TABLE masterclass ADD composer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE masterclass ADD CONSTRAINT FK_9BDB44ED7A8D2620 FOREIGN KEY (composer_id) REFERENCES composer (id)');
        $this->addSql('CREATE INDEX IDX_9BDB44ED7A8D2620 ON masterclass (composer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE masterclass DROP FOREIGN KEY FK_9BDB44ED7A8D2620');
        $this->addSql('DROP INDEX IDX_9BDB44ED7A8D2620 ON masterclass');
        $this->addSql('ALTER TABLE masterclass DROP composer_id');
        $this->addSql('ALTER TABLE composer ADD masterclass_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8426F0705 FOREIGN KEY (masterclass_id) REFERENCES masterclass (id)');
        $this->addSql('CREATE INDEX IDX_987306D8426F0705 ON composer (masterclass_id)');
    }
}
