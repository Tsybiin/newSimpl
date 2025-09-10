<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250826185230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE key_vpn (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, id_user VARCHAR(255) DEFAULT NULL, date_send DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE open_vpn_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, ip VARCHAR(255) DEFAULT NULL, bytes_received DOUBLE PRECISION DEFAULT NULL, bytes_sent DOUBLE PRECISION DEFAULT NULL, connected_since DATETIME DEFAULT NULL, date_update DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_tg (id INT AUTO_INCREMENT NOT NULL, id_telegram VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, id_open_vpn_key VARCHAR(255) DEFAULT NULL, date_register DATETIME DEFAULT NULL, auth_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE key_vpn');
        $this->addSql('DROP TABLE open_vpn_status');
        $this->addSql('DROP TABLE user_tg');
    }
}
