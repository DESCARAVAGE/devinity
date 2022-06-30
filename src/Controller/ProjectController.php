<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/project/{id}', name: 'project_')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/index.html.twig', [
            'project' => $project,
        ]);
    }
}
