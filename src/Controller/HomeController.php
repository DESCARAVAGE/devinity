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
    public function index(ProjectRepository $projectRepository, IdeaRepository $ideaRepository, Request $request): Response
    {
        $form = $this->createForm(SearchProjectType::class);
        $form->handleRequest($request);

        $searchProjects = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            $searchProjects = $projectRepository->search($search);
        }
        
        $lastProjects = $projectRepository->findBy([],['date'=>'DESC'], 5);
        

        $mostFollowed = $projectRepository->findMostFollowed();

        return $this->renderForm('home/index.html.twig', [
            'lastProjects' => $lastProjects,
            'searchProjects' => $searchProjects,
            'mostFollowed' => $mostFollowed,
            'form' => $form
        ]);
    }


    #[Route('/user', name: 'user_index', methods: ['GET'])]
    public function showUser(): Response
    {
        return $this->render('user/index.html.twig', []);
    }
}
