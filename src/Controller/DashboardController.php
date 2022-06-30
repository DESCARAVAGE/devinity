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
    public function index(IdeaRepository $ideaRepository, ProjectRepository $projectRepository): Response
    {
        $ideas = $ideaRepository->findAll();
        $projects = $projectRepository->findAll();
        return $this->render('dashboard/index.html.twig', [
            'ideas' => $ideas,
            'projects' => $projects,
        ]);
    }

    #[Route('/idea/{id}', methods: ['GET'], name: 'show_idea')]
    public function showId(int $id, IdeaRepository $ideaRepository): Response
    {
        $idea = $ideaRepository->findOneById($id);
        return $this->render('dashboard/showIdea.html.twig', [
            'idea' => $idea,
            'ideaId' => $id,
        ]);
    }

    #[Route('/project/{id}', methods: ['GET'], name: 'show_project')]
    public function showProject(int $id, ProjectRepository $projectRepository): Response
    {
        
        $project = $projectRepository->findOneById($id);
        return $this->render('dashboard/showProject.html.twig', [
            'project' => $project,
            'projectId' => $id,
        ]);
    }
}