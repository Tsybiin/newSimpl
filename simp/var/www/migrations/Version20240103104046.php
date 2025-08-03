<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240103104046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create table';
    }

    public function up(Schema $schema): void
    {
        // user
         $this->addSql('create table user_tg
(
    id INT AUTO_INCREMENT NOT NULL
        primary key,
    id_telegram    VARCHAR(255)     null,
    first_name    VARCHAR(255)     null,
    last_name    VARCHAR(255)     null,
    username    VARCHAR(255)     null,
    id_open_vpn_key INT          null,
    date_register DATETIME DEFAULT NULL,
    auth_date DATETIME DEFAULT NULL
)
    collate = utf8mb3_unicode_ci');

//         // key_vpn
//          $this->addSql('create table key_vpn
// (
//     ID INT AUTO_INCREMENT NOT NULL
//         primary key,
//     NAME    VARCHAR(255) NOT NULL,
//     DATE_SEND DATETIME DEFAULT NULL
// )
//     collate = utf8mb3_unicode_ci');
//
//         // log_vpn_status
//         $this->addSql('create table  log_vpn_status
// (
//     ID INT AUTO_INCREMENT NOT NULL
//         primary key,
//     NAME    VARCHAR(255) NOT NULL,
//     DATE_UPDATE DATETIME DEFAULT NULL
// )
//     collate = utf8mb3_unicode_ci');
    }


    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE log_vpn_status');
        $this->addSql('DROP TABLE key_vpn');
    }
}
