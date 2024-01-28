<?php

namespace App\Controller;

use App\Entity\Pacc;
use App\Form\PaccType;
use App\Repository\PaccRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pacc')]
class PaccController extends AbstractController
{
    #[Route('/', name: 'app_pacc_index', methods: ['GET'])]
    public function index(PaccRepository $paccRepository): Response
    {
        return $this->render('backend/pacc/index.html.twig', [
            'paccs' => $paccRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pacc_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pacc = new Pacc();
        $form = $this->createForm(PaccType::class, $pacc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pacc);
            $entityManager->flush();

            return $this->redirectToRoute('app_pacc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/pacc/new.html.twig', [
            'pacc' => $pacc,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pacc_show', methods: ['GET'])]
    public function show(Pacc $pacc): Response
    {
        return $this->render('backend/pacc/show.html.twig', [
            'pacc' => $pacc,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pacc_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pacc $pacc, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PaccType::class, $pacc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pacc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/pacc/edit.html.twig', [
            'pacc' => $pacc,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pacc_delete', methods: ['POST'])]
    public function delete(Request $request, Pacc $pacc, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pacc->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pacc);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pacc_index', [], Response::HTTP_SEE_OTHER);
    }
}
