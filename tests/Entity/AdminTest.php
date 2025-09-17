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

use App\Entity\Admin;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the Admin entity.
 */
class AdminTest extends TestCase
{
    /**
     * Tests all getters and setters of the Admin entity.
     *
     * @return void
     */
    public function testGettersAndSetters(): void
    {
        $admin = new Admin();

        // Test username
        $admin->setUsername('admin_user');
        $this->assertEquals('admin_user', $admin->getUsername());
        $this->assertEquals('admin_user', $admin->getUserIdentifier());

        // Test roles
        $admin->setRoles(['ROLE_ADMIN']);
        $this->assertEquals(['ROLE_ADMIN'], $admin->getRoles());

        // Test password
        $admin->setPassword('hashed_password');
        $this->assertEquals('hashed_password', $admin->getPassword());

        // Test ID is null initially
        $this->assertNull($admin->getId());

        // Test eraseCredentials (should not throw)
        $admin->eraseCredentials();
        $this->assertTrue(true); // Ensure the method exists
    }
}
