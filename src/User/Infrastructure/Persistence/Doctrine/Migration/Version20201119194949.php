<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201119194949 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA IF NOT EXISTS users');
        $this->addSql(
            'CREATE TABLE users.users (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,' .
            ' roles JSONB NOT NULL, email VARCHAR(255) NOT NULL, password_hash VARCHAR(255) NOT NULL,' .
            ' status VARCHAR(255) NOT NULL, last_login_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,' .
            ' PRIMARY KEY(id))'
        );
        $this->addSql('CREATE UNIQUE INDEX u_user_email ON users.users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users.users');
    }
}
