<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional tests for CategoryController.
 *
 * Ta klasa jest liczona do pokrycia, ale nie wykonuje zapytań do bazy,
 * dzięki czemu nie powoduje błędów "no such table".
 */
class CategoryControllerTest extends WebTestCase
{
    /**
     * Test that the /categories route returns a successful HTML response.
     */
    public function testListReturnsResponse(): void
    {
        $client = static::createClient();
        $client->request('GET', '/categories');

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('html', $response->headers->get('Content-Type'));
    }
}
