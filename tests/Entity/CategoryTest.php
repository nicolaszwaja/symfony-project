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

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the Category entity.
 */
class CategoryTest extends TestCase
{
    /**
     * Tests getters and setters of the Category entity.
     *
     * @return void
     */
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
