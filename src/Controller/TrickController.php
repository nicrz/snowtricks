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
use App\Form\CommentType;
use App\Form\MediaType;
use App\Form\MediaVideoType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Security;

class TrickController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }


    /**
     * @Route("/trick/{trickid}", name="trick_details")
     */
    public function show($trickid, TrickRepository $TrickRepository, MediaRepository $MediaRepository, CommentRepository $CommentRepository, Request $request, SluggerInterface $slugger, ManagerRegistry $doctrine)
    {
        $trick = $TrickRepository
            ->findOneBy(['id' => $trickid]);

        $pictures = $MediaRepository
            ->showImagesFromTrick($trickid);

        $videos = $MediaRepository
            ->showVideosFromTrick($trickid);

        $comments = $CommentRepository
            ->showValidComments($trickid);

        $pendingcomments = $CommentRepository
            ->showPendingComments($trickid);

            // COMMENTS FORM

            $newComment = new Comment();
            $form = $this->createForm(CommentType::class, $newComment);
    
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
    
                $content = $form->get('content')->getData();
                $idtrick = $form->get('idtrick')->getData();
                //$iduser = $form->get('iduser')->getData();
                $trick = $doctrine->getRepository(Trick::class)->findOneBy(['id' => $idtrick]);
                //$user = $doctrine->getRepository(User::class)->find(1);
                $user = $this->getUser();
                var_dump($user);
                die();
                $newComment->setContent($content);
                $newComment->setDate(new \DateTime('@'.strtotime('now')));
                $newComment->setValid(0);
                $newComment->setTrick($trick);   
                $newComment->setUser($user);
    
                $manager = $doctrine->getManager();
                $manager->persist($newComment);
                $manager->flush();
    
                return $this->redirectToRoute('trick_details', ['trickid' => $idtrick, dump($idtrick),]);
            }

            // PICTURES GALLERY FORM

            $newImage = new Media();
            $picturesform = $this->createForm(MediaType::class, $newImage);
    
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
    
                $images = $form->get('name')->getData();
                $idtrick = $form->get('idtrick')->getData();
              
    
                foreach ($images as $image){
                    
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try {
                        $image->move(
                            'images/tricks',
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    $trick = $doctrine->getRepository(Trick::class)->findOneBy(['id' => $idtrick]);

                    
                    $newImage->setTrick($trick);
                    $newImage->setType(1);
                    $newImage->setName($newFilename);
            }   
    
    
                $manager = $doctrine->getManager();
                $manager->persist($newImage);
                $manager->flush();
    
                return $this->redirectToRoute('trick_details', ['trickid' => $idtrick]);
            }

            // VIDEO GALLERY FORM

            $newVideo = new Media();
            $videosform = $this->createForm(MediaVideoType::class, $newVideo);
    
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
    
                $code = $form->get('code')->getData();
                $idtrick = $form->get('idtrick')->getData();   

                $trick = $doctrine->getRepository(Trick::class)->findOneBy(['id' => $idtrick]);
                    
                $newImage->setTrick($trick);
                $newImage->setType(2);
                $newImage->setCode($code);
    
    
                $manager = $doctrine->getManager();
                $manager->persist($newImage);
                $manager->flush();
    
                return $this->redirectToRoute('trick_details', ['trickid' => $idtrick]);
            }

        return $this->render('trick.html.twig',[
            'trick' => $trick,
            'pictures' => $pictures,
            'videos' => $videos,
            'comments' => $comments,
            'pendingcomments' => $pendingcomments,
            "formView" => $form->createView(),
            "formPictures" => $picturesform->createView(),
            "formVideos" => $videosform->createView(),
            dump($comments),
        ]);
    }



    /**
     * @Route("/trick/{trickid}/comment/{id}/delete", name="comment_delete", requirements={"id" = "\d+"})
     */
    public function deleteComment(ManagerRegistry $doctrine, $trickid, Comment $comment)
    {

        $manager = $doctrine->getManager();
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash("warning", "Le commentaire a bien été supprimé");
        return $this->redirectToRoute('trick_details', ['trickid' => $trickid]);
    }
}