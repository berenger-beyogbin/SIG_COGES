<?php

namespace App\Controller;

use App\Entity\Depenses;
use App\Form\DepensesType;
use App\Repository\DepenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/depenses')]
class DepensesController extends AbstractController
{
    #[Route('/', name: 'app_depenses_index', methods: ['GET'])]
    public function index(DepenseRepository $depensesRepository): Response
    {
        return $this->render('backend/depenses/index.html.twig', [
            'depenses' => $depensesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_depenses_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $depense = new Depenses();
        $form = $this->createForm(DepensesType::class, $depense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($depense);
            $entityManager->flush();

            return $this->redirectToRoute('app_depenses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/depenses/new.html.twig', [
            'depense' => $depense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_depenses_show', methods: ['GET'])]
    public function show(Depenses $depense): Response
    {
        return $this->render('backend/depenses/show.html.twig', [
            'depense' => $depense,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_depenses_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Depenses $depense, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepensesType::class, $depense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_depenses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/depenses/edit.html.twig', [
            'depense' => $depense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_depenses_delete', methods: ['POST'])]
    public function delete(Request $request, Depenses $depense, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$depense->getId(), $request->request->get('_token'))) {
            $entityManager->remove($depense);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_depenses_index', [], Response::HTTP_SEE_OTHER);
    }
}
