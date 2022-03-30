<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330101746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE telegram_user (uid INT NOT NULL, twitter_user_id INT NOT NULL, INDEX IDX_F180F0596B1F2707 (twitter_user_id), PRIMARY KEY(uid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE twitter_user (uid INT NOT NULL, token VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL, refresh_token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(uid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE telegram_user ADD CONSTRAINT FK_F180F0596B1F2707 FOREIGN KEY (twitter_user_id) REFERENCES twitter_user (uid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE telegram_user DROP FOREIGN KEY FK_F180F0596B1F2707');
        $this->addSql('DROP TABLE telegram_user');
        $this->addSql('DROP TABLE twitter_user');
    }
}
