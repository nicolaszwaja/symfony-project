<?php

namespace App\Tests\Service;

use App\Entity\Category;
use App\Entity\Post;
use App\Repository\CategoryRepository;
use App\Service\CategoryService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryServiceTest extends TestCase
{
    public function testGetAllCategoriesReturnsArray(): void
    {
        $category1 = new Category();
        $category1->setName('Cat1');
        $category2 = new Category();
        $category2->setName('Cat2');

        $repository = $this->createMock(CategoryRepository::class);
        $repository->method('findAll')->willReturn([$category1, $category2]);

        $service = new CategoryService($repository);

        $result = $service->getAllCategories();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertSame($category1, $result[0]);
        $this->assertSame($category2, $result[1]);
    }

    public function testGetPostsByCategoryIdReturnsCategoryAndPosts(): void
{
    $category = new class extends \App\Entity\Category {
        public function getPosts(): array
        {
            return ['Post1', 'Post2'];
        }
    };

    $repository = $this->createMock(CategoryRepository::class);
    $repository->method('find')->with(1)->willReturn($category);

    $service = new CategoryService($repository);

    $result = $service->getPostsByCategoryId(1);

    $this->assertArrayHasKey('category', $result);
    $this->assertArrayHasKey('posts', $result);
    $this->assertSame($category, $result['category']);
    $this->assertSame(['Post1', 'Post2'], $result['posts']);
}

}
