<?php

namespace App\Controller;

use App\Entity\MembreOrgane;
use App\Form\MembreOrganeType;
use App\Repository\MembreOrganeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/membreorgane')]
class MembreOrganeController extends AbstractController
{
    #[Route('/', name: 'app_membre_organe_index', methods: ['GET'])]
    public function index(MembreOrganeRepository $membreOrganeRepository): Response
    {
        return $this->render('backend/membre_organe/index.html.twig', [
            'membre_organes' => $membreOrganeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_membre_organe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $membreOrgane = new MembreOrgane();
        $form = $this->createForm(MembreOrganeType::class, $membreOrgane);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($membreOrgane);
            $entityManager->flush();

            return $this->redirectToRoute('app_membre_organe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/membre_organe/new.html.twig', [
            'membre_organe' => $membreOrgane,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_membre_organe_show', methods: ['GET'])]
    public function show(MembreOrgane $membreOrgane): Response
    {
        return $this->render('backend/membre_organe/show.html.twig', [
            'membre_organe' => $membreOrgane,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_membre_organe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MembreOrgane $membreOrgane, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MembreOrganeType::class, $membreOrgane);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_membre_organe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/membre_organe/edit.html.twig', [
            'membre_organe' => $membreOrgane,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_membre_organe_delete', methods: ['POST'])]
    public function delete(Request $request, MembreOrgane $membreOrgane, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membreOrgane->getId(), $request->request->get('_token'))) {
            $entityManager->remove($membreOrgane);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_membre_organe_index', [], Response::HTTP_SEE_OTHER);
    }
}
