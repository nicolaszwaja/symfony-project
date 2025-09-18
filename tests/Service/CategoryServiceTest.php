<?php

declare(strict_types=1);

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
use App\Repository\CategoryRepository;
use App\Service\CategoryService;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the CategoryService.
 */
class CategoryServiceTest extends TestCase
{
    /**
     * Test that getAllCategories() returns an array of categories.
     */
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

    /**
     * Test that getPostsByCategoryId() returns the category and its posts.
     */
    public function testGetPostsByCategoryIdReturnsCategoryAndPosts(): void
    {
        $category = new class() extends \App\Entity\Category {
            /**
             * Simulate getPosts() returning an array of posts.
             */
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
