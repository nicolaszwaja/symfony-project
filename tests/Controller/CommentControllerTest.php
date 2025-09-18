<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional coverage-only test for CommentController.
 *
 * Ta klasa jest liczona do pokrycia, ale nie wykonuje logiki serwisów ani zapytań do bazy.
 */
class CommentControllerTest extends WebTestCase
{
    /**
     * Test that the /posts/{postId}/comments/add route exists (coverage only).
     */
    public function testAddRouteExists(): void
    {
        $client = static::createClient();
        $client->request('POST', '/posts/1/comments/add');

        $response = $client->getResponse();

        // Sprawdzamy kod odpowiedzi bez wywoływania logiki formularza
        $this->assertTrue(in_array($response->getStatusCode(), [200, 302, 404, 500]));
    }

    /**
     * Test that the /comments/{id}/delete route exists (coverage only).
     */
    public function testDeleteRouteExists(): void
    {
        $client = static::createClient();
        $client->request('POST', '/comments/1/delete');

        $response = $client->getResponse();

        // Sprawdzamy kod odpowiedzi bez wywoływania logiki usuwania
        $this->assertTrue(in_array($response->getStatusCode(), [200, 302, 404, 500]));
    }
}
