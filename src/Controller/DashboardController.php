<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\IdeaRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard', name: 'dashboard_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(IdeaRepository $ideaRepository): Response
    {
        $myIdeas = $ideaRepository->findBy(['user'=> $this->getUser()], ['id' => 'DESC']);
        return $this->render('dashboard/index.html.twig', [
            'myIdeas' => $myIdeas
        ]);
    }

    #[Route('/{id}', methods: ['GET'], name: 'show_idea')]
    public function showId(int $id, IdeaRepository $ideaRepository): Response
    {
        $idea = $ideaRepository->findOneById($id);
        return $this->render('dashboard/show_idea.html.twig', [
            'idea' => $idea,
            'id' => $id,
        ]);
    }

    #[Route('/{id}', methods: ['GET'], name: 'show_project')]
    public function showProject(int $id, ProjectRepository $projectRepository): Response
    {
        
        $project = $projectRepository->findOneById($id);
        return $this->render('dashboard/show_project.html.twig', [
            'project' => $project,
            'id' => $id,
        ]);
    }
}