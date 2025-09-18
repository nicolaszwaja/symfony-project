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

use App\Entity\Category;
use App\Entity\Post;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Service\PostService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the PostService.
 */
class PostServiceTest extends TestCase
{
    /**
     * Test that getPostById() returns the correct Post entity.
     */
    public function testGetPostByIdReturnsPost(): void
    {
        $post = new Post();
        $post->setTitle('Test Post');

        $postRepository = $this->createMock(PostRepository::class);
        $postRepository->method('find')->with(1)->willReturn($post);

        $service = new PostService(
            $postRepository,
            $this->createMock(CategoryRepository::class),
            $this->createMock(PaginatorInterface::class)
        );

        $this->assertSame($post, $service->getPostById(1));
    }

    /**
     * Test that savePost() persists and flushes the Post entity.
     */
    public function testSavePostPersistsAndFlushes(): void
    {
        $post = new Post();
        $post->setTitle('Test Post');

        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())->method('persist')->with($post);
        $em->expects($this->once())->method('flush');

        $service = new PostService(
            $this->createMock(PostRepository::class),
            $this->createMock(CategoryRepository::class),
            $this->createMock(PaginatorInterface::class)
        );

        $service->savePost($post, $em);
    }

    /**
     * Test that deletePost() removes and flushes the Post entity.
     */
    public function testDeletePostRemovesAndFlushes(): void
    {
        $post = new Post();
        $post->setTitle('Test Post');

        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())->method('remove')->with($post);
        $em->expects($this->once())->method('flush');

        $service = new PostService(
            $this->createMock(PostRepository::class),
            $this->createMock(CategoryRepository::class),
            $this->createMock(PaginatorInterface::class)
        );

        $service->deletePost($post, $em);
    }

    /**
     * Test that changeCategory() with a valid category sets the category on the post.
     */
    public function testChangeCategoryWithValidCategorySetsCategory(): void
    {
        $post = new Post();
        $post->setTitle('Test Post');

        $category = new Category();
        $category->setName('Test Category');

        $categoryRepository = $this->createMock(CategoryRepository::class);
        $categoryRepository->method('find')->with(1)->willReturn($category);

        $service = new PostService(
            $this->createMock(PostRepository::class),
            $categoryRepository,
            $this->createMock(PaginatorInterface::class)
        );

        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())->method('flush');

        $service->changeCategory($post, 1, $em);

        $this->assertSame($category, $post->getCategory());
    }

    /**
     * Test that getCategories() returns all categories as an array.
     */
    public function testGetCategoriesReturnsArray(): void
    {
        $category1 = new Category();
        $category1->setName('Cat1');
        $category2 = new Category();
        $category2->setName('Cat2');

        $categoryRepository = $this->createMock(CategoryRepository::class);
        $categoryRepository->method('findAll')->willReturn([$category1, $category2]);

        $service = new PostService(
            $this->createMock(PostRepository::class),
            $categoryRepository,
            $this->createMock(PaginatorInterface::class)
        );

        $result = $service->getCategories();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertSame($category1, $result[0]);
        $this->assertSame($category2, $result[1]);
    }
}
