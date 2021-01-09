<?php

namespace App\Controller;

use App\Entity\Program;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
             ->getRepository(Program::class)
             ->findBy(
                [], 
                ['id' => 'DESC'],
                3
            );
        return $this->render('/index.html.twig', [
            'website' => 'Wild Séries',
            'programs' => $programs
        ]);
    }

    public function navbarTop(CategoryRepository $categoryRepository): Response
    {
        return $this->render('layout/navbartop.html.twig', [
            'categories' => $categoryRepository->findBy([], ['id' => 'DESC'])
        ]);
    }

}
