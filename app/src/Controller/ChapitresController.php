<?php

namespace App\Controller;

use App\Entity\Chapitre;
use App\Form\ChapitresType;
use App\Repository\ChapitreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/chapitres')]
class ChapitresController extends AbstractController
{
    #[Route('/', name: 'app_chapitres_index', methods: ['GET'])]
    public function index(ChapitreRepository $chapitresRepository): Response
    {
        return $this->render('backend/chapitres/index.html.twig', [
            'chapitres' => $chapitresRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_chapitres_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chapitre = new Chapitre();
        $form = $this->createForm(ChapitresType::class, $chapitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chapitre);
            $entityManager->flush();

            return $this->redirectToRoute('app_chapitres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/chapitres/new.html.twig', [
            'chapitre' => $chapitre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chapitres_show', methods: ['GET'])]
    public function show(Chapitre $chapitre): Response
    {
        return $this->render('backend/chapitres/show.html.twig', [
            'chapitre' => $chapitre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chapitres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chapitre $chapitre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChapitresType::class, $chapitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_chapitres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/chapitres/edit.html.twig', [
            'chapitre' => $chapitre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chapitres_delete', methods: ['POST'])]
    public function delete(Request $request, Chapitre $chapitre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chapitre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($chapitre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chapitres_index', [], Response::HTTP_SEE_OTHER);
    }
}
