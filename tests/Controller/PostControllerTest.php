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

use App\Service\PostServiceInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional tests for PostController.
 */
class PostControllerTest extends WebTestCase
{
    /**
     * Test that the /posts route returns a successful HTML response.
     *
     * @return void
     */
    public function testListReturnsResponse(): void
    {
        $client = static::createClient();

        $paginationMock = $this->createMock(PaginationInterface::class);
        $postServiceMock = $this->createMock(PostServiceInterface::class);
        $postServiceMock->method('getPaginatedPosts')->willReturn($paginationMock);
        $postServiceMock->method('getCategories')->willReturn([]);

        $client->getContainer()->set(PostServiceInterface::class, $postServiceMock);

        $client->request('GET', '/posts');
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('html', $response->headers->get('Content-Type'));
    }
}
