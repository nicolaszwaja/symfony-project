<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250825162145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial schema for MySQL (admin, category, post, comment)';
    }

    public function up(Schema $schema): void
    {
        // Admin
        $this->addSql(<<<'SQL'
            CREATE TABLE admin (
                id INT AUTO_INCREMENT NOT NULL,
                username VARCHAR(180) NOT NULL,
                roles JSON NOT NULL,
                password VARCHAR(255) NOT NULL,
                UNIQUE INDEX UNIQ_880E0D76F85E0677 (username),
                PRIMARY KEY(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        SQL);

        // Category
        $this->addSql(<<<'SQL'
            CREATE TABLE category (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        SQL);

        // Post
        $this->addSql(<<<'SQL'
            CREATE TABLE post (
                id INT AUTO_INCREMENT NOT NULL,
                category_id INT NOT NULL,
                title VARCHAR(255) NOT NULL,
                content LONGTEXT NOT NULL,
                created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
                INDEX IDX_5A8A6C8D12469DE2 (category_id),
                PRIMARY KEY(id),
                CONSTRAINT FK_5A8A6C8D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        SQL);

        // Comment
        $this->addSql(<<<'SQL'
            CREATE TABLE comment (
                id INT AUTO_INCREMENT NOT NULL,
                post_id INT NOT NULL,
                nickname VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                content LONGTEXT NOT NULL,
                created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
                INDEX IDX_9474526C4B89032C (post_id),
                PRIMARY KEY(id),
                CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE admin');
    }
}
