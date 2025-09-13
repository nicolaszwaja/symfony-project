<?php

namespace App\Tests\Controller;

use App\Entity\Post;
use App\Service\PostServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DummyPostController
{
    public function __construct(private readonly PostServiceInterface $postService)
    {
    }

    public function delete(Post $post, EntityManagerInterface $em): Response
    {
        $this->postService->deletePost($post, $em);
        // symulacja redirectToRoute
        return new Response('', 302);
    }

    public function changeCategory(Request $request, Post $post, EntityManagerInterface $em): Response
    {
        $categoryId = $request->request->getInt('category_id');
        $this->postService->changeCategory($post, $categoryId, $em);
        // symulacja redirectToRoute
        return new Response('', 302);
    }
}

class PostControllerTest extends TestCase
{
    public function testDeleteReturnsRedirectResponse(): void
    {
        $mockService = $this->createMock(PostServiceInterface::class);
        $mockService->expects($this->once())->method('deletePost');

        $mockEm = $this->createMock(EntityManagerInterface::class);
        $post = new Post();

        $controller = new DummyPostController($mockService);
        $response = $controller->delete($post, $mockEm);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testChangeCategoryReturnsRedirectResponse(): void
    {
        $mockService = $this->createMock(PostServiceInterface::class);
        $mockService->expects($this->once())->method('changeCategory');

        $mockEm = $this->createMock(EntityManagerInterface::class);
        $post = new Post();
        $request = new Request([], ['category_id' => 5]);

        $controller = new DummyPostController($mockService);
        $response = $controller->changeCategory($request, $post, $mockEm);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }
}
