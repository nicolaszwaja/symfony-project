<?php

namespace App\Tests\Entity;

use App\Entity\Admin;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
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
        $this->assertTrue(true); // Po prostu upewniamy się, że metoda istnieje
    }
}
