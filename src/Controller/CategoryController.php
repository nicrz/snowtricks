<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Security;

class CategoryController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }


    /**
     * @Route("/categories", name="categories_list")
     */
    public function show(CategoryRepository $CategoryRepository, Request $request, SluggerInterface $slugger, ManagerRegistry $doctrine)
    {

        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès refusé');
        }
        
        $categories = $CategoryRepository
            ->findAll();


        return $this->render('categories_list.html.twig',[
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/add_category", name="category_add", requirements={"id" = "\d+"})
     */
    public function addCategory(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
    {

        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès refusé');
        }

        $newCategory = new Category();
        $form = $this->createForm(CategoryType::class, $newCategory);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $manager = $doctrine->getManager();
            $manager->persist($newCategory);
            $manager->flush();

            $this->addFlash('newcateg-success', 'Catégorie ajoutée avec succès!');

            return $this->redirectToRoute('categories_list');
        }

        return $this->render('category_add.html.twig',[
            "formView" => $form->createView(),
        ]);

    }

    /**
     * @Route("/category/{id}/edit", name="category_edit", requirements={"id" = "\d+"})
     */
    public function editCategory(Category $category, ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
    {

        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès refusé');
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $manager = $doctrine->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash('editcateg-success', 'Catégorie modifiée avec succès!');
            return $this->redirectToRoute('categories_list');

        }

        return $this->render('category_edit.html.twig',[
            "formView" => $form->createView(),
        ]);

    }

    /**
     * @Route("/category/{id}/delete", name="category_delete", requirements={"id" = "\d+"})
     */
    public function deleteCategory(ManagerRegistry $doctrine, $id, Category $category)
    {

        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès refusé');
        }

        $manager = $doctrine->getManager();
        $manager->remove($category);
        $manager->flush();

        $this->addFlash('deletecateg-success', 'Catégorie supprimée avec succès!');
        return $this->redirectToRoute('categories_list');
    }

}