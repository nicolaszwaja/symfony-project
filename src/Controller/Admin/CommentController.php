<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route('/admin/comments/', name: 'comments_list')]
    public function list(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findAll();

        return $this->render('admin/comment/list.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[\Symfony\Component\Routing\Attribute\Route('/admin/comments/{id}/delete', name: 'comments_delete')]
    public function delete(int $id, CommentRepository $commentRepository, EntityManagerInterface $em): Response
    {
        $comment = $commentRepository->find($id);

        if ($comment instanceof \App\Entity\Comment) {
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comments_list');
    }
}
