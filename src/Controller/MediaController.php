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

class MediaController extends AbstractController
{

    /**
     * @Route("/trick/{trickid}/media/{id}/delete", name="media_delete", requirements={"id" = "\d+"})
     */
    public function deleteMedia(ManagerRegistry $doctrine, $trickid, Media $media)
    {

        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès refusé');
        }

        $manager = $doctrine->getManager();
        $manager->remove($media);
        $manager->flush();

        $this->addFlash("warning", "Le media a bien été supprimé");
        return $this->redirectToRoute('trick_details', ['trickid' => $trickid]);
    }
}