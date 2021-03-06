<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Media;
use App\Entity\Comment;
use App\Entity\User;
use App\Repository\TrickRepository;
use App\Repository\MediaRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use App\Forms\CommentType;
use App\Forms\MediaType;
use App\Forms\MediaVideoType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CommentController extends AbstractController
{

    /**
     * @Route("/trick/{trickid}/comment/{id}/validate", name="comment_validation", requirements={"id" = "\d+"})
     */
    public function commentValidation(ManagerRegistry $doctrine, $trickid, $id, Comment $comment)
    {

        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès refusé');
        }

        $entityManager = $doctrine->getManager();
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        if (!$comment) {
            throw $this->createNotFoundException(
                'Ce commentaire n existe pas '
            );
        }

        $comment->setValid(1);
        $entityManager->flush();
        return $this->redirectToRoute('trick_details', ['trickid' => $trickid]);
    }

    /**
     * @Route("/trick/{trickid}/comment/{id}/delete", name="comment_delete", requirements={"id" = "\d+"})
     */
    public function deleteComment(ManagerRegistry $doctrine, $trickid, Comment $comment)
    {

        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès refusé');
        }

        $manager = $doctrine->getManager();
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash("warning", "Le commentaire a bien été supprimé");
        return $this->redirectToRoute('trick_details', ['trickid' => $trickid]);
    }
}