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
     * @param CommentServiceInterface $commentService
     */
    public function __construct(private readonly CommentServiceInterface $commentService)
    {
    }

    /**
     * Adds a new comment to a post.
     *
     * @param Request                $request The HTTP request
     * @param int                    $postId  The ID of the post
     * @param EntityManagerInterface $em      The entity manager
     *
     * @return Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException When post does not exist
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
     * Deletes a comment.
     *
     * @param Comment                $comment The comment to delete
     * @param EntityManagerInterface $em      The entity manager
     *
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/comments/{id}/delete', name: 'comment_delete', methods: ['POST'])]
    public function delete(Comment $comment, EntityManagerInterface $em): Response
    {
        $this->commentService->deleteComment($comment, $em);
        $this->addFlash('success', 'Komentarz został usunięty.');

        return $this->redirectToRoute('admin_dashboard');
    }
}
