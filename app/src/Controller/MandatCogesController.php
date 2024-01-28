<?php

namespace App\Controller;

use App\Entity\MandatCoges;
use App\Form\MandatCogesType;
use App\Repository\MandatCogesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/mandatcoges')]
class MandatCogesController extends AbstractController
{
    #[Route('/', name: 'app_mandat_coges_index', methods: ['GET'])]
    public function index(MandatCogesRepository $mandatCogesRepository): Response
    {
        return $this->render('backend/mandat_coges/index.html.twig', [
            'mandat_coges' => $mandatCogesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mandat_coges_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mandatCoge = new MandatCoges();
        $form = $this->createForm(MandatCogesType::class, $mandatCoge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mandatCoge);
            $entityManager->flush();

            return $this->redirectToRoute('app_mandat_coges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/mandat_coges/new.html.twig', [
            'mandat_coge' => $mandatCoge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mandat_coges_show', methods: ['GET'])]
    public function show(MandatCoges $mandatCoge): Response
    {
        return $this->render('backend/mandat_coges/show.html.twig', [
            'mandat_coge' => $mandatCoge,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mandat_coges_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MandatCoges $mandatCoge, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MandatCogesType::class, $mandatCoge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mandat_coges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/mandat_coges/edit.html.twig', [
            'mandat_coge' => $mandatCoge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mandat_coges_delete', methods: ['POST'])]
    public function delete(Request $request, MandatCoges $mandatCoge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mandatCoge->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mandatCoge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mandat_coges_index', [], Response::HTTP_SEE_OTHER);
    }
}
