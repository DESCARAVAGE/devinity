<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Status;
use App\Form\SearchProjectType;
use App\Repository\IdeaRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(ProjectRepository $projectRepository, Request $request): Response
    {
        $lastProjects = $projectRepository->findBy([],['date'=>'DESC'], 5);
        
        $mostFollowed = $projectRepository->findMostFollowed();

        return $this->renderForm('home/index.html.twig', [
            'lastProjects' => $lastProjects,
            'mostFollowed' => $mostFollowed,
        ]);
    }


    #[Route('/user', name: 'user_index', methods: ['GET'])]
    public function showUser(): Response
    {
        return $this->render('dashboard/index.html.twig', [

        ]);
    }
}
