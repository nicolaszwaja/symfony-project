<?php
/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Tests\Service;

use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Service\CommentService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the CommentService.
 */
class CommentServiceTest extends TestCase
{
    /**
     * Test that getPostById() returns the correct Post entity.
     *
     * @return void
     */
    public function testGetPostByIdReturnsPost(): void
    {
        $post = new Post();
        $post->setTitle('Test Post');

        $postRepository = $this->createMock(PostRepository::class);
        $postRepository->method('find')->with(1)->willReturn($post);

        $service = new CommentService($postRepository);

        $this->assertSame($post, $service->getPostById(1));
    }

    /**
     * Test that addComment() persists and flushes the comment.
     *
     * @return void
     */
    public function testAddCommentPersistsAndFlushes(): void
    {
        $comment = new Comment();

        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())->method('persist')->with($comment);
        $em->expects($this->once())->method('flush');

        $service = new CommentService($this->createMock(PostRepository::class));
        $service->addComment($comment, $em);
    }

    /**
     * Test that deleteComment() removes and flushes the comment.
     *
     * @return void
     */
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
