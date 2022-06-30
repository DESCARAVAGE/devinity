<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index')]
    public function index(ProjectRepository $projectRepository):Response 
    {
        $user = $this->getUser();
        $lastProjects = $projectRepository->findBy([], ['date' => 'DESC'], 5);
        $myProjects = $projectRepository->findBy(['participants' => $user], ['date' => 'DESC'], 5);

        return $this->render('home/index.html.twig', [
            'lastProjects' => $lastProjects,
            'myProjects' => $myProjects,
        ]);
    }
}
