<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/comments', name: 'comments_')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findAll();

        return $this->render('admin/comment/list.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(int $id, CommentRepository $commentRepository, EntityManagerInterface $em): Response
    {
        $comment = $commentRepository->find($id);

        if ($comment) {
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comments_list');
    }
}
