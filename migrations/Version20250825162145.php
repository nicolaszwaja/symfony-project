<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250825162145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial schema for SQLite (admin, category, post, comment)';
    }

    public function up(Schema $schema): void
    {
        // Admin
        $this->addSql(<<<'SQL'
            CREATE TABLE admin (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                username VARCHAR(180) NOT NULL,
                roles TEXT NOT NULL,
                password VARCHAR(255) NOT NULL,
                CONSTRAINT UNIQ_admin_username UNIQUE (username)
            )
        SQL);

        // Category
        $this->addSql(<<<'SQL'
            CREATE TABLE category (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL
            )
        SQL);

        // Post
        $this->addSql(<<<'SQL'
            CREATE TABLE post (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                category_id INTEGER NOT NULL,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                created_at DATETIME NOT NULL,
                CONSTRAINT FK_post_category FOREIGN KEY (category_id) REFERENCES category (id)
            )
        SQL);
        $this->addSql('CREATE INDEX IDX_post_category ON post (category_id)');

        // Comment
        $this->addSql(<<<'SQL'
            CREATE TABLE comment (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                post_id INTEGER NOT NULL,
                nickname VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                created_at DATETIME NOT NULL,
                CONSTRAINT FK_comment_post FOREIGN KEY (post_id) REFERENCES post (id)
            )
        SQL);
        $this->addSql('CREATE INDEX IDX_comment_post ON comment (post_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE admin');
    }
}
