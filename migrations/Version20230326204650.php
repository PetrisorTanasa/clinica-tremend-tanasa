<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326204650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comentarii');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE statistici_vizitatori');
        $this->addSql('DROP TABLE statisticivizitatori');
        $this->addSql('DROP TABLE stiri');
        $this->addSql('ALTER TABLE account ADD surname VARCHAR(255) NOT NULL, ADD role VARCHAR(255) NOT NULL, ADD status VARCHAR(255) NOT NULL, ADD bearer_token VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP mail, DROP parola, DROP rol, DROP identificator');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comentarii (id INT AUTO_INCREMENT NOT NULL, nume_comentator VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, id_anunt INT NOT NULL, comentariu VARCHAR(4000) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, mail VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, nume VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, feedback VARCHAR(1000) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, rating VARCHAR(5) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, headers LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, queue_name VARCHAR(190) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E016BA31DB (delivered_at), INDEX IDX_75EA56E0E3BD61CE (available_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE statistici_vizitatori (id INT AUTO_INCREMENT NOT NULL, sistem VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, count INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE statisticivizitatori (id INT NOT NULL, sistem VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, count INT NOT NULL) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE stiri (id INT AUTO_INCREMENT NOT NULL, titlu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, rezumat VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, text VARCHAR(8000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, poza1 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, poza2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, poza3 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, autor VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, identificator VARCHAR(400) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE account ADD mail VARCHAR(255) NOT NULL, ADD parola VARCHAR(255) NOT NULL, ADD rol INT NOT NULL, ADD identificator VARCHAR(30) NOT NULL, DROP surname, DROP role, DROP status, DROP bearer_token, DROP password');
    }
}
