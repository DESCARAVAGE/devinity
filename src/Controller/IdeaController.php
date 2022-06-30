<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Form\IdeaType;
use App\Entity\Project;
use App\Form\SearchProjectType;
use App\Repository\IdeaRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/idea')]
class IdeaController extends AbstractController
{
    #[Route('/', name: 'app_idea_index', methods: ['GET', 'POST'])]
    public function index(IdeaRepository $ideaRepository, Request $request): Response
    {

        $form = $this->createForm(SearchProjectType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            $ideas = $ideaRepository->search($search);
        } else {
            $ideas = $ideaRepository->findAll();
        }

        return $this->renderForm('idea/index.html.twig', [
            'ideas' => $ideas,
            'form' => $form
        ]);
    }

    #[Route('/new', name: 'app_idea_new', methods: ['GET', 'POST'])]
    public function new(Request $request, IdeaRepository $ideaRepository, ProjectRepository $projectRepository): Response
    {
        $user = $this->getUser();
        $idea = new Idea();
        $form = $this->createForm(IdeaType::class, $idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ideaRepository->add($idea, true);

            $project = new Project();
            $project->setName($idea->getName());
            $project->addParticipant($user);
            $projectRepository->add($project, true);

            return $this->redirectToRoute('dashboard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('idea/new.html.twig', [
            'idea' => $idea,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_idea_show', methods: ['GET'])]
    public function show(Idea $idea): Response
    {
        return $this->render('idea/show.html.twig', [
            'idea' => $idea,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_idea_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Idea $idea, IdeaRepository $ideaRepository): Response
    {
        $form = $this->createForm(IdeaType::class, $idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ideaRepository->add($idea, true);

            return $this->redirectToRoute('app_idea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('idea/edit.html.twig', [
            'idea' => $idea,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_idea_delete', methods: ['POST'])]
    public function delete(Request $request, Idea $idea, IdeaRepository $ideaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$idea->getId(), $request->request->get('_token'))) {
            $ideaRepository->remove($idea, true);
        }

        return $this->redirectToRoute('app_idea_index', [], Response::HTTP_SEE_OTHER);
    }
}
