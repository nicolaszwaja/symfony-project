<?php

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class PostService implements PostServiceInterface
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly PaginatorInterface $paginator,
    ) {
    }

    public function getPaginatedPosts(Request $request, int $page, int $limit = 10): PaginationInterface
    {
        $categoryId = $request->query->get('category');

        $query = $this->postRepository->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC');

        if ($categoryId) {
            $query->andWhere('p.category = :cat')
                ->setParameter('cat', $categoryId);
        }

        return $this->paginator->paginate(
            $query,
            $page,
            $limit
        );
    }

    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    public function savePost(Post $post, EntityManagerInterface $em): void
    {
        $em->persist($post);
        $em->flush();
    }

    public function deletePost(Post $post, EntityManagerInterface $em): void
    {
        $em->remove($post);
        $em->flush();
    }

    public function changeCategory(Post $post, ?int $categoryId, EntityManagerInterface $em): void
    {
        $category = $categoryId ? $this->categoryRepository->find($categoryId) : null;
        $post->setCategory($category);
        $em->flush();
    }

    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
    }
}
