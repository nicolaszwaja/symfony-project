<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $category = new Category();

        // Test initial ID
        $this->assertNull($category->getId());

        // Test name getter/setter
        $category->setName('Test Category');
        $this->assertEquals('Test Category', $category->getName());
    }
}
