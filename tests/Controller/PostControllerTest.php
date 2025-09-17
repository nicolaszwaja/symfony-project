<?php

namespace App\Tests\Controller;

use App\Service\PostServiceInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
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
