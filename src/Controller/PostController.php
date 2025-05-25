<?php
// src/Controller/PostController.php
namespace App\Controller;


use App\Entity\Comment;
use App\Form\CommentTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PostRepository;
use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


class PostController extends AbstractController{
    #[Route('/posts', name: 'posts_list')]
    public function list(PostRepository $postRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $postRepository->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('post/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    #[Route('/posts/{id}', name: 'post_show')]
    public function show(int $id, PostRepository $postRepository, Request $request, EntityManagerInterface $em): Response
    {
        $post = $postRepository->find($id);
        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        // Tworzymy nowy komentarz przypisany do tego posta
        $comment = new Comment();
        $comment->setPost($post);
        $comment->setCreatedAt(new \DateTimeImmutable());

        // Tworzymy formularz
        // $form = $this->createForm(CommentTypeForm::class, $comment);
        $form = $this->createForm(CommentTypeForm::class, $comment, [
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'post_item', // dowolna nazwa
        ]);
        
        $form->handleRequest($request);

        // Obsługa formularza w tym samym kontrolerze (opcjonalnie)
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('post_show', ['id' => $id]);
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),  // przekazujemy form do szablonu
        ]);
    }
    #[Route('/new', name: 'post_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $post = new Post();
        $post->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(PostType::class, $post, [
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'post_item', // dowolna nazwa
        ]);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();
    
            return $this->redirectToRoute('posts_list');
        }
    
        return $this->render('post/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'post_edit')]
    public function edit(Post $post, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('posts_list');
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

}

