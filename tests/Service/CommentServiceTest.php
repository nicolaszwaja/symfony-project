<?php

namespace App\Tests\Service;

use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Service\CommentService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class CommentServiceTest extends TestCase
{
    public function testGetPostByIdReturnsPost(): void
    {
        $post = new Post();
        $post->setTitle('Test Post');

        $postRepository = $this->createMock(PostRepository::class);
        $postRepository->method('find')->with(1)->willReturn($post);

        $service = new CommentService($postRepository);

        $this->assertSame($post, $service->getPostById(1));
    }

    public function testAddCommentPersistsAndFlushes(): void
    {
        $comment = new Comment();

        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())->method('persist')->with($comment);
        $em->expects($this->once())->method('flush');

        $service = new CommentService($this->createMock(PostRepository::class));
        $service->addComment($comment, $em);
    }

    public function testDeleteCommentRemovesAndFlushes(): void
    {
        $comment = new Comment();

        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())->method('remove')->with($comment);
        $em->expects($this->once())->method('flush');

        $service = new CommentService($this->createMock(PostRepository::class));
        $service->deleteComment($comment, $em);
    }
}
