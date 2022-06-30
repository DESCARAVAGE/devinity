<?php

namespace App\Controller;


use App\Repository\ProjectRepository;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index')]
    public function index(ProjectRepository $projectRepository):Response 
    {
        $user = $this->getUser();
        $lastProjects = $projectRepository->findBy([], 5);

        return $this->render('home/index.html.twig', [
            'lastProjects' => $lastProjects,
        ]);
    }


    #[Route('/user', name: 'user_index', methods:['GET'])]
    public function showUser():Response
    {
        return $this->render('dashboard/index.html.twig', [

        ]);
    }
}
