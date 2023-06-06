<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606105437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE badge (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classroom (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_497D309DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classroom_question (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, xp_value INT NOT NULL, proposition LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classroom_quizz (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, counter INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classroom_quizz_classroom_question (classroom_quizz_id INT NOT NULL, classroom_question_id INT NOT NULL, INDEX IDX_C85BDBF38FAC12F6 (classroom_quizz_id), INDEX IDX_C85BDBF3EB0637DB (classroom_question_id), PRIMARY KEY(classroom_quizz_id, classroom_question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, formation_lvl_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_404021BFA76ED395 (user_id), UNIQUE INDEX UNIQ_404021BF708F2159 (formation_lvl_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_lvl (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, progression INT DEFAULT NULL, progression_xp INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_34BD7D21A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fun_fact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instrument (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE masterclass (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, instrument_id INT DEFAULT NULL, masterclass_lvl_id INT DEFAULT NULL, fun_fact_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, video VARCHAR(255) NOT NULL, certification VARCHAR(255) NOT NULL, partition_file VARCHAR(255) DEFAULT NULL, INDEX IDX_9BDB44EDA76ED395 (user_id), INDEX IDX_9BDB44EDCF11D9C (instrument_id), UNIQUE INDEX UNIQ_9BDB44EDCB7F6FB7 (masterclass_lvl_id), UNIQUE INDEX UNIQ_9BDB44ED53209B43 (fun_fact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE masterclass_composer (masterclass_id INT NOT NULL, composer_id INT NOT NULL, INDEX IDX_E78582C426F0705 (masterclass_id), INDEX IDX_E78582C7A8D2620 (composer_id), PRIMARY KEY(masterclass_id, composer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE masterclass_masterclass_quizz (masterclass_id INT NOT NULL, masterclass_quizz_id INT NOT NULL, INDEX IDX_B37B363B426F0705 (masterclass_id), INDEX IDX_B37B363B2C981539 (masterclass_quizz_id), PRIMARY KEY(masterclass_id, masterclass_quizz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE masterclass_formation (masterclass_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_FA061CE4426F0705 (masterclass_id), INDEX IDX_FA061CE45200282E (formation_id), PRIMARY KEY(masterclass_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE masterclass_lvl (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, progression INT DEFAULT NULL, progression_xp INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_9811EB4EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE masterclass_question (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, answer VARCHAR(255) NOT NULL, xp_value INT DEFAULT NULL, proposition LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE masterclass_quizz (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, counter INT DEFAULT NULL, INDEX IDX_F1F5E4FDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE masterclass_quizz_masterclass_question (masterclass_quizz_id INT NOT NULL, masterclass_question_id INT NOT NULL, INDEX IDX_718E9B262C981539 (masterclass_quizz_id), INDEX IDX_718E9B261F008477 (masterclass_question_id), PRIMARY KEY(masterclass_quizz_id, masterclass_question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_badge (user_id INT NOT NULL, badge_id INT NOT NULL, INDEX IDX_1C32B345A76ED395 (user_id), INDEX IDX_1C32B345F7A2C2FC (badge_id), PRIMARY KEY(user_id, badge_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_event (user_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_D96CF1FFA76ED395 (user_id), INDEX IDX_D96CF1FF71F7E88B (event_id), PRIMARY KEY(user_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classroom ADD CONSTRAINT FK_497D309DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE classroom_quizz_classroom_question ADD CONSTRAINT FK_C85BDBF38FAC12F6 FOREIGN KEY (classroom_quizz_id) REFERENCES classroom_quizz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classroom_quizz_classroom_question ADD CONSTRAINT FK_C85BDBF3EB0637DB FOREIGN KEY (classroom_question_id) REFERENCES classroom_question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF708F2159 FOREIGN KEY (formation_lvl_id) REFERENCES formation_lvl (id)');
        $this->addSql('ALTER TABLE formation_lvl ADD CONSTRAINT FK_34BD7D21A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE masterclass ADD CONSTRAINT FK_9BDB44EDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE masterclass ADD CONSTRAINT FK_9BDB44EDCF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('ALTER TABLE masterclass ADD CONSTRAINT FK_9BDB44EDCB7F6FB7 FOREIGN KEY (masterclass_lvl_id) REFERENCES masterclass_lvl (id)');
        $this->addSql('ALTER TABLE masterclass ADD CONSTRAINT FK_9BDB44ED53209B43 FOREIGN KEY (fun_fact_id) REFERENCES fun_fact (id)');
        $this->addSql('ALTER TABLE masterclass_composer ADD CONSTRAINT FK_E78582C426F0705 FOREIGN KEY (masterclass_id) REFERENCES masterclass (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE masterclass_composer ADD CONSTRAINT FK_E78582C7A8D2620 FOREIGN KEY (composer_id) REFERENCES composer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE masterclass_masterclass_quizz ADD CONSTRAINT FK_B37B363B426F0705 FOREIGN KEY (masterclass_id) REFERENCES masterclass (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE masterclass_masterclass_quizz ADD CONSTRAINT FK_B37B363B2C981539 FOREIGN KEY (masterclass_quizz_id) REFERENCES masterclass_quizz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE masterclass_formation ADD CONSTRAINT FK_FA061CE4426F0705 FOREIGN KEY (masterclass_id) REFERENCES masterclass (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE masterclass_formation ADD CONSTRAINT FK_FA061CE45200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE masterclass_lvl ADD CONSTRAINT FK_9811EB4EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE masterclass_quizz ADD CONSTRAINT FK_F1F5E4FDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE masterclass_quizz_masterclass_question ADD CONSTRAINT FK_718E9B262C981539 FOREIGN KEY (masterclass_quizz_id) REFERENCES masterclass_quizz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE masterclass_quizz_masterclass_question ADD CONSTRAINT FK_718E9B261F008477 FOREIGN KEY (masterclass_question_id) REFERENCES masterclass_question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_badge ADD CONSTRAINT FK_1C32B345A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_badge ADD CONSTRAINT FK_1C32B345F7A2C2FC FOREIGN KEY (badge_id) REFERENCES badge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FF71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classroom DROP FOREIGN KEY FK_497D309DA76ED395');
        $this->addSql('ALTER TABLE classroom_quizz_classroom_question DROP FOREIGN KEY FK_C85BDBF38FAC12F6');
        $this->addSql('ALTER TABLE classroom_quizz_classroom_question DROP FOREIGN KEY FK_C85BDBF3EB0637DB');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BFA76ED395');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF708F2159');
        $this->addSql('ALTER TABLE formation_lvl DROP FOREIGN KEY FK_34BD7D21A76ED395');
        $this->addSql('ALTER TABLE masterclass DROP FOREIGN KEY FK_9BDB44EDA76ED395');
        $this->addSql('ALTER TABLE masterclass DROP FOREIGN KEY FK_9BDB44EDCF11D9C');
        $this->addSql('ALTER TABLE masterclass DROP FOREIGN KEY FK_9BDB44EDCB7F6FB7');
        $this->addSql('ALTER TABLE masterclass DROP FOREIGN KEY FK_9BDB44ED53209B43');
        $this->addSql('ALTER TABLE masterclass_composer DROP FOREIGN KEY FK_E78582C426F0705');
        $this->addSql('ALTER TABLE masterclass_composer DROP FOREIGN KEY FK_E78582C7A8D2620');
        $this->addSql('ALTER TABLE masterclass_masterclass_quizz DROP FOREIGN KEY FK_B37B363B426F0705');
        $this->addSql('ALTER TABLE masterclass_masterclass_quizz DROP FOREIGN KEY FK_B37B363B2C981539');
        $this->addSql('ALTER TABLE masterclass_formation DROP FOREIGN KEY FK_FA061CE4426F0705');
        $this->addSql('ALTER TABLE masterclass_formation DROP FOREIGN KEY FK_FA061CE45200282E');
        $this->addSql('ALTER TABLE masterclass_lvl DROP FOREIGN KEY FK_9811EB4EA76ED395');
        $this->addSql('ALTER TABLE masterclass_quizz DROP FOREIGN KEY FK_F1F5E4FDA76ED395');
        $this->addSql('ALTER TABLE masterclass_quizz_masterclass_question DROP FOREIGN KEY FK_718E9B262C981539');
        $this->addSql('ALTER TABLE masterclass_quizz_masterclass_question DROP FOREIGN KEY FK_718E9B261F008477');
        $this->addSql('ALTER TABLE user_badge DROP FOREIGN KEY FK_1C32B345A76ED395');
        $this->addSql('ALTER TABLE user_badge DROP FOREIGN KEY FK_1C32B345F7A2C2FC');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FFA76ED395');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FF71F7E88B');
        $this->addSql('DROP TABLE badge');
        $this->addSql('DROP TABLE classroom');
        $this->addSql('DROP TABLE classroom_question');
        $this->addSql('DROP TABLE classroom_quizz');
        $this->addSql('DROP TABLE classroom_quizz_classroom_question');
        $this->addSql('DROP TABLE composer');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_lvl');
        $this->addSql('DROP TABLE fun_fact');
        $this->addSql('DROP TABLE instrument');
        $this->addSql('DROP TABLE masterclass');
        $this->addSql('DROP TABLE masterclass_composer');
        $this->addSql('DROP TABLE masterclass_masterclass_quizz');
        $this->addSql('DROP TABLE masterclass_formation');
        $this->addSql('DROP TABLE masterclass_lvl');
        $this->addSql('DROP TABLE masterclass_question');
        $this->addSql('DROP TABLE masterclass_quizz');
        $this->addSql('DROP TABLE masterclass_quizz_masterclass_question');
        $this->addSql('DROP TABLE user_badge');
        $this->addSql('DROP TABLE user_event');
    }
}
