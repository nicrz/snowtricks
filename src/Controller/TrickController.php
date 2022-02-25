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
use App\Forms\TrickType;
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
                $trick = $doctrine->getRepository(Trick::class)->findOneBy(['id' => $trickid]);
                //$user = $doctrine->getRepository(User::class)->find(1);
                $user = $this->getUser();
                //var_dump($user);
                //die();
                $newComment->setContent($content);
                $newComment->setDate(new \DateTime('@'.strtotime('now')));
                $newComment->setValid(0);
                $newComment->setTrick($trick);   
                $newComment->setUser($user);
    
                $manager = $doctrine->getManager();
                $manager->persist($newComment);
                $manager->flush();

                $this->addFlash('success', 'Commentaire soumis à la modération!');
    
                return $this->redirectToRoute('trick_details', ['trickid' => $trickid]);
            }

            // PICTURES GALLERY FORM

            $newImage = new Media();
            $picturesform = $this->createForm(MediaType::class, $newImage);
    
            $picturesform->handleRequest($request);
            if($picturesform->isSubmitted() && $picturesform->isValid()) {
    
                $images = $picturesform->get('name')->getData();
                $idtrick = $picturesform->get('idtrick')->getData();
              
    
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
    
            $videosform->handleRequest($request);
            if($videosform->isSubmitted() && $videosform->isValid()) {
    
                $code = $videosform->get('code')->getData();
                $idtrick = $videosform->get('idtrick')->getData();   

                $trick = $doctrine->getRepository(Trick::class)->findOneBy(['id' => $idtrick]);
                    
                $newVideo->setTrick($trick);
                $newVideo->setName('Video');
                $newVideo->setType(2);
                $newVideo->setCode($code);
    
    
                $manager = $doctrine->getManager();
                $manager->persist($newVideo);
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
        ]);
    }

    /**
     * @Route("/add_trick", name="trick_add", requirements={"id" = "\d+"})
     */
    public function addTrick(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
    {

        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès refusé');
        }

        $newTrick = new Trick();
        $form = $this->createForm(TrickType::class, $newTrick);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $author = $this->getUser();

            $image = $form->get('main_image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
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

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $newTrick->setMain_image($newFilename);
            }

            $newTrick->setCreated_at(new \DateTime('@'.strtotime('now')));
            $newTrick->setAuthor($author);
            $manager = $doctrine->getManager();
            $manager->persist($newTrick);
            $manager->flush();

            $this->addFlash('newtrick-success', 'Figure ajoutée avec succès!');

            return $this->redirectToRoute('home');
        }

        return $this->render('trick_add.html.twig',[
            "formView" => $form->createView(),
        ]);

    }

    /**
     * @Route("/trick/{id}/edit", name="trick_edit", requirements={"id" = "\d+"})
     */
    public function editTrick(ManagerRegistry $doctrine, Request $request, Trick $trick, SluggerInterface $slugger)
    {

        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès refusé');
        }

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('main_image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
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

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $trick->setMain_image($newFilename);
            }
            $manager = $doctrine->getManager();
            $manager->flush();

            return $this->redirectToRoute('trick_edit', ['id' => $trick->getId()]);
        }

        return $this->render('trick_edit.html.twig',[
            "formView" => $form->createView(),
        ]);

    }

    /**
     * @Route("/trick/{id}/delete", name="trick_delete", requirements={"id" = "\d+"})
     */
    public function deleteTrick(ManagerRegistry $doctrine, $id, Trick $trick)
    {

        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès refusé');
        }

        $manager = $doctrine->getManager();
        $manager->remove($trick);
        $manager->flush();

        $this->addFlash('delete-success', 'Figure supprimée avec succès!');
        return $this->redirectToRoute('home');
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