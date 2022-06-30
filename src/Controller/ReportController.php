<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Report;
use App\Form\ReportType;
use App\Repository\ProjectRepository;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/report')]
class ReportController extends AbstractController
{

    #[Route('/{id}/new', name: 'app_report_new', methods: ['GET', 'POST'])]
    public function new(Project $project, EntityManagerInterface $manager,  Request $request, ReportRepository $reportRepository): Response
    {
        $report = new Report();
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);
        $id = $project->getId();
        if ($form->isSubmitted() && $form->isValid()) {
            $reportRepository->add($report, true);
            $project->addReport($report);
            $manager->persist(($project));
            $manager->flush();

            return $this->redirectToRoute('project_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('report/new.html.twig', [
            'report' => $report,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_report_show', methods: ['GET'])]
    public function show(Report $report): Response
    {
        return $this->render('report/show.html.twig', [
            'report' => $report,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_report_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Report $report, ReportRepository $reportRepository): Response
    {
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reportRepository->add($report, true);

            return $this->redirectToRoute('app_report_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('report/edit.html.twig', [
            'report' => $report,
            'form' => $form,
        ]);
    }

}
