<?php
// src/Controller/PostController.php
namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentTypeForm;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class PostController extends AbstractController
{
    #[Route('/posts', name: 'post_list')]
    public function list(PostRepository $postRepository, CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $categoryId = $request->query->get('category');

        $query = $postRepository->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC'); // <-- tutaj sortowanie od najnowszych

        if ($categoryId) {
            $query->andWhere('p.category = :cat')
                ->setParameter('cat', $categoryId);
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        $categories = $categoryRepository->findAll();

        return $this->render('post/list.html.twig', [
            'pagination' => $pagination,
            'categories' => $categories,
            'currentCategory' => $categoryId,
        ]);
    }


    #[Route('/posts/{id}', name: 'post_show')]
    public function show(int $id, PostRepository $postRepository, Request $request, EntityManagerInterface $em): Response
    {
        $post = $postRepository->find($id);
        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        $comment = new Comment();
        $comment->setPost($post);
        $comment->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(CommentTypeForm::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('post_show', ['id' => $id]);
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'post_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $post = new Post();
        $post->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(PostType::class, $post, [
            'csrf_protection' => true,
            'csrf_field_name' => '_token',      // domyślna nazwa
            'csrf_token_id'   => 'post_item',   // musi być zgodne w formularzu
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('admin_dashboard');;
        }

        return $this->render('post/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'post_edit')]
    public function edit(Post $post, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PostType::class, $post, [
            'csrf_protection' => true,
            'csrf_field_name' => '_token',      // domyślna nazwa
            'csrf_token_id'   => 'post_item',   // musi być zgodne w formularzu
        ]);
        $form->handleRequest($request);

        // debug bez wysyłania outputu do przeglądarki
        if ($form->isSubmitted() && !$form->isValid()) {
            // np. logujemy błędy lub pokazujemy jako flash message
            foreach ($form->getErrors(true, false) as $error) {
                $this->addFlash('danger', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush(); 
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('post/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
        ]);
    }




    #[Route('/admin/posts/{id}/delete', name: 'post_delete', methods: ['POST'])]
    public function delete(Post $post, EntityManagerInterface $em): Response
    {
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'Post został usunięty.');

        return $this->redirectToRoute('admin_dashboard');
    }

    #[Route('/admin/post/{id}/change-category', name: 'post_change_category', methods: ['POST'])]
    public function changeCategory(
        Request $request,
        Post $post,
        EntityManagerInterface $em,
        CategoryRepository $categoryRepo
    ): Response {
        $categoryId = $request->request->get('category_id');
        $category = $categoryId ? $categoryRepo->find($categoryId) : null;

        $post->setCategory($category);
        $em->flush();

        return $this->redirectToRoute('admin_dashboard');
    }

}
