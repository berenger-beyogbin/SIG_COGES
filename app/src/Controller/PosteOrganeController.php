<?php

namespace App\Controller;

use App\Entity\PosteOrgane;
use App\Form\PosteOrganeType;
use App\Repository\PosteOrganeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/posteorgane')]
class PosteOrganeController extends AbstractController
{
    #[Route('/', name: 'app_poste_organe_index', methods: ['GET'])]
    public function index(PosteOrganeRepository $posteOrganeRepository): Response
    {
        return $this->render('poste_organe/index.html.twig', [
            'poste_organes' => $posteOrganeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_poste_organe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $posteOrgane = new PosteOrgane();
        $form = $this->createForm(PosteOrganeType::class, $posteOrgane);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($posteOrgane);
            $entityManager->flush();

            return $this->redirectToRoute('app_poste_organe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('poste_organe/new.html.twig', [
            'poste_organe' => $posteOrgane,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_poste_organe_show', methods: ['GET'])]
    public function show(PosteOrgane $posteOrgane): Response
    {
        return $this->render('poste_organe/show.html.twig', [
            'poste_organe' => $posteOrgane,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_poste_organe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PosteOrgane $posteOrgane, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PosteOrganeType::class, $posteOrgane);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_poste_organe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('poste_organe/edit.html.twig', [
            'poste_organe' => $posteOrgane,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_poste_organe_delete', methods: ['POST'])]
    public function delete(Request $request, PosteOrgane $posteOrgane, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$posteOrgane->getId(), $request->request->get('_token'))) {
            $entityManager->remove($posteOrgane);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_poste_organe_index', [], Response::HTTP_SEE_OTHER);
    }
}
