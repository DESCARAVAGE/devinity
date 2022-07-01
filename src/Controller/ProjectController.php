<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\StatusRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/project', name: 'project_')]
class ProjectController extends AbstractController
{
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(HttpFoundationRequest $request, ProjectRepository $projectRepository, StatusRepository $statusRepository): Response
    {
        $user = $this->getUser();
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->addParticipant($user);
            $project->setDate(new DateTime('now'));
            $project->setStatus($statusRepository->findOneById(3));
            $projectRepository->add($project, true);
            return $this->redirectToRoute('project_show_ideas', ['id' => $project->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/ideas', name: 'show_ideas', methods: ['GET'])]
    public function showIdeas(Project $project): Response
    {
        return $this->render('idea/show.html.twig', [
            'project' => $project,
            'ideas' => $project->getIdeas()
        ]);
    }
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/index.html.twig', [
            'project' => $project,
        ]);
    }
}
