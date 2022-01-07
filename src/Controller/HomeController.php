<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function show(TrickRepository $TrickRepository)
    {
        $tricks = $TrickRepository
            ->findAll();

        return $this->render('home.html.twig',[
            'tricks' => $tricks,
        ]);
    }
}