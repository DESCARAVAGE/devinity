<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index')]
    public function index():Response 
    {
        return $this->render('home/index.html.twig', [

        ]);
    }


    #[Route('/user', name: 'user_index', methods:['GET'])]
    public function showUser():Response
    {
        return $this->render('user/index.html.twig', [

        ]);
    }
}
