<?php

namespace App\Tests\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use App\Service\PostService;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class PostServiceTest extends TestCase
{
    private PostRepository $postRepository;
    private CategoryRepository $categoryRepository;
    private PaginatorInterface $paginator;
    private PostService $postService;

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

    public function testGetPostByIdReturnsPost(): void
    {
        $post = new Post();
        $this->postRepository
            ->method('find')
            ->willReturn($post);

        $result = $this->postService->getPostById(1);

        $this->assertSame($post, $result);
    }

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
