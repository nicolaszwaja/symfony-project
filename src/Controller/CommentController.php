<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentTypeForm;
use App\Service\CommentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for handling adding and deleting comments.
 */
class CommentController extends AbstractController
{
    /**
     * CommentController constructor.
     *
     * @param CommentServiceInterface $commentService The service handling comment-related business logic
     */
    public function __construct(private readonly CommentServiceInterface $commentService)
    {
    }

    /**
     * Adds a new comment to a specific post.
     *
     * @param Request                $request The HTTP request containing comment data
     * @param int                    $postId  The unique ID of the post
     * @param EntityManagerInterface $em      The entity manager responsible for persistence
     *
     * @return Response The rendered view or a redirect to the post page
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException When the post does not exist
     */
    #[\Symfony\Component\Routing\Attribute\Route('/posts/{postId}/comments/add', name: 'comment_add', methods: ['POST'])]
    public function add(Request $request, int $postId, EntityManagerInterface $em): Response
    {
        $post = $this->commentService->getPostById($postId);
        if (!$post instanceof \App\Entity\Post) {
            throw $this->createNotFoundException('Post nie istnieje');
        }

        $comment = new Comment();
        $comment->setPost($post);
        $comment->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(CommentTypeForm::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->addComment($comment, $em);

            return $this->redirectToRoute('post_show', ['id' => $postId]);
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a comment from the system.
     *
     * @param Comment                $comment The comment entity to remove
     * @param EntityManagerInterface $em      The entity manager handling the deletion
     *
     * @return Response Redirects to the admin dashboard after deletion
     */
    #[\Symfony\Component\Routing\Attribute\Route('/comments/{id}/delete', name: 'comment_delete', methods: ['POST'])]
    public function delete(Comment $comment, EntityManagerInterface $em): Response
    {
        $this->commentService->deleteComment($comment, $em);
        $this->addFlash('success', 'Komentarz został usunięty.');

        return $this->redirectToRoute('admin_dashboard');
    }
}
