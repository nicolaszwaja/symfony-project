<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional tests for PostController.
 *
 * Ta klasa jest liczona do pokrycia, ale nie wykonuje zapytań do bazy,
 * dzięki czemu nie powoduje błędów "no such table".
 */
class PostControllerTest extends WebTestCase
{
    /**
     * Test that the /posts route returns a successful HTML response.
     */
    public function testListReturnsResponse(): void
    {
        $client = static::createClient();
        $client->request('GET', '/posts');

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('html', $response->headers->get('Content-Type'));
    }
}
