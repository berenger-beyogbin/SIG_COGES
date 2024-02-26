<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecettesType;
use App\Repository\PaccRepository;
use App\Repository\RecetteRepository;
use App\Repository\SourceRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/recette')]
class RecettesController extends AbstractController
{
    #[Route('/', name: 'app_recette_index', methods: ['GET'])]
    public function index(RecetteRepository $recettesRepository): Response
    {
        return $this->render('recettes/index.html.twig', [
            'recettes' => $recettesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_recette_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Connection $connection, RecetteRepository $recetteRepository): Response
    {
        if($request->isXmlHttpRequest()){
            $recette = $recetteRepository->findOneBy(['pacc' => $request->get('pacc'), 'source' => $request->get('source')]);

            if($recette) return $this->json(['duplicate' => true, 'source' => $request->get('source')]);

            $connection->insert('recette', [
                'montant_recette' => $request->get('montant_recette'),
                'source_id' => $request->get('source'),
                'pacc_id' => $request->get('pacc'),
            ]);

            $recettes = $recetteRepository->findBy(['pacc' => $request->get('pacc')]);
            $total_recettes = 0;
            foreach($recettes as $recette){
                $total_recettes += $recette->getMontantRecette();
            }
            $response = $this->renderView("backend/recettes/table_ajax.html.twig", ["recettes" => $recettes, "total_recettes" => $total_recettes]);
            return $this->json($response);
        }else{
            $recette = new Recette();
            $form = $this->createForm(RecettesType::class, $recette);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $recetteRepository->add($recette, true);

                return $this->redirectToRoute('app_recette_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('recettes/new.html.twig', [
                'recette' => $recette,
                'form' => $form,
            ]);
        }

    }

    #[Route('/{id}', name: 'app_recette_show', methods: ['GET'])]
    public function show(Recette $recette): Response
    {
        return $this->render('recettes/show.html.twig', [
            'recette' => $recette,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recette_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recette $recette, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecettesType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_recette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recettes/edit.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recette_delete', methods: ['POST'])]
    public function delete(Request $request, Recette $recette, EntityManagerInterface $entityManager): Response
    {
        if($request->isXmlHttpRequest()){
            $entityManager->remove($recette);
            $entityManager->flush();
            return $this->json(['result' => 'success']);
        }else {
            if ($this->isCsrfTokenValid('delete' . $recette->getId(), $request->request->get('_token'))) {
                $entityManager->remove($recette);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_recette_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}
