<?php
/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Tests\Entity;

use App\Entity\Comment;
use App\Entity\Post;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the Comment entity.
 */
class CommentTest extends TestCase
{
    /**
     * Tests getters and setters of the Comment entity.
     *
     * @return void
     */
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
