<?php

namespace App\Controller;

use App\Entity\Status;
use App\Repository\ProjectRepository;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findBy([],['date'=>'DESC'],5);
        return $this->render('home/index.html.twig', [
            'projects' => $projects,
        ]);
    }


    #[Route('/user', name: 'user_index', methods: ['GET'])]
    public function showUser(): Response
    {
        return $this->render('user/index.html.twig', []);
    }
}
