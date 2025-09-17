<?php

namespace App\Tests\Entity;

use App\Entity\Comment;
use App\Entity\Post;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $comment = new Comment();
        $post = $this->createMock(Post::class);

        // Test ID is initially null
        $this->assertNull($comment->getId());

        // Test Post
        $comment->setPost($post);
        $this->assertSame($post, $comment->getPost());

        // Test nickname
        $comment->setNickname('John Doe');
        $this->assertEquals('John Doe', $comment->getNickname());

        // Test email
        $comment->setEmail('john@example.com');
        $this->assertEquals('john@example.com', $comment->getEmail());

        // Test content
        $comment->setContent('This is a test comment.');
        $this->assertEquals('This is a test comment.', $comment->getContent());

        // Test createdAt
        $createdAt = new \DateTimeImmutable('2025-01-01 12:00:00');
        $comment->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $comment->getCreatedAt());
    }
}
