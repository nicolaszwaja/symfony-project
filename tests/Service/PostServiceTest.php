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

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use App\Service\PostService;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Unit tests for the PostService class.
 */
class PostServiceTest extends TestCase
{
    private PostRepository $postRepository;
    private CategoryRepository $categoryRepository;
    private PaginatorInterface $paginator;
    private PostService $postService;

    /**
     * Sets up the test environment with mocked dependencies.
     */
    protected function setUp(): void
    {
        $this->postRepository = $this->createMock(PostRepository::class);
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);

        $this->postService = new PostService(
            $this->postRepository,
            $this->categoryRepository,
            $this->paginator
        );
    }

    /**
     * Tests that getPaginatedPosts() returns a PaginationInterface instance.
     */
    public function testGetPaginatedPostsReturnsPagination(): void
    {
        $request = new Request();
        $page = 1;

        $paginationMock = $this->createMock(PaginationInterface::class);
        $this->paginator
            ->method('paginate')
            ->willReturn($paginationMock);

        $result = $this->postService->getPaginatedPosts($request, $page);

        $this->assertSame($paginationMock, $result);
    }

    /**
     * Tests that getPostById() returns a Post entity.
     */
    public function testGetPostByIdReturnsPost(): void
    {
        $post = new Post();
        $this->postRepository
            ->method('find')
            ->willReturn($post);

        $result = $this->postService->getPostById(1);

        $this->assertSame($post, $result);
    }

    /**
     * Tests that getCategories() returns an array of categories.
     */
    public function testGetCategoriesReturnsArray(): void
    {
        $categories = ['cat1', 'cat2'];
        $this->categoryRepository
            ->method('findAll')
            ->willReturn($categories);

        $result = $this->postService->getCategories();

        $this->assertSame($categories, $result);
    }
}
