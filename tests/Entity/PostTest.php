<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $post = new Post();
        $category = $this->createMock(Category::class);
        $comment1 = $this->createMock(Comment::class);
        $comment2 = $this->createMock(Comment::class);

        // Test ID initially null
        $this->assertNull($post->getId());

        // Category
        $post->setCategory($category);
        $this->assertSame($category, $post->getCategory());

        // Title
        $post->setTitle('Test Title');
        $this->assertEquals('Test Title', $post->getTitle());

        // Content
        $post->setContent('Test Content');
        $this->assertEquals('Test Content', $post->getContent());

        // CreatedAt
        $createdAt = new \DateTimeImmutable('2025-01-01 12:00:00');
        $post->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $post->getCreatedAt());

        // Comments initially empty
        $this->assertCount(0, $post->getComments());

        // Add comments
        $post->addComment($comment1);
        $post->addComment($comment2);
        $this->assertCount(2, $post->getComments());
        $this->assertTrue($post->getComments()->contains($comment1));
        $this->assertTrue($post->getComments()->contains($comment2));

        // Remove a comment
        $post->removeComment($comment1);
        $this->assertCount(1, $post->getComments());
        $this->assertFalse($post->getComments()->contains($comment1));
    }
}
