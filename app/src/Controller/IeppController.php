<?php

namespace App\Controller;

use App\Entity\Iepp;
use App\Form\IeppType;
use App\Repository\IeppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/iepp')]
class IeppController extends AbstractController
{
    #[Route('/', name: 'app_iepp_index', methods: ['GET'])]
    public function index(IeppRepository $ieppRepository): Response
    {
        return $this->render('backend/iepp/index.html.twig', [
            'iepps' => $ieppRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_iepp_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $iepp = new Iepp();
        $form = $this->createForm(IeppType::class, $iepp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($iepp);
            $entityManager->flush();

            return $this->redirectToRoute('app_iepp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/iepp/new.html.twig', [
            'iepp' => $iepp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_iepp_show', methods: ['GET'])]
    public function show(Iepp $iepp): Response
    {
        return $this->render('backend/iepp/show.html.twig', [
            'iepp' => $iepp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_iepp_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Iepp $iepp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IeppType::class, $iepp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_iepp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/iepp/edit.html.twig', [
            'iepp' => $iepp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_iepp_delete', methods: ['POST'])]
    public function delete(Request $request, Iepp $iepp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$iepp->getId(), $request->request->get('_token'))) {
            $entityManager->remove($iepp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_iepp_index', [], Response::HTTP_SEE_OTHER);
    }
}
