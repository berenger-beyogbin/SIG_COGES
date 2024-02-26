<?php

namespace App\Controller;

use App\Entity\Depense;
use App\Form\DepensesType;
use App\Repository\DepenseRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/depense')]
class DepensesController extends AbstractController
{
    #[Route('/', name: 'app_depense_index', methods: ['GET'])]
    public function index(DepenseRepository $depensesRepository): Response
    {
        return $this->render('backend/depenses/index.html.twig', [
            'depenses' => $depensesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_depense_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DepenseRepository $depenseRepository, Connection $connection): Response
    {
        if($request->isXmlHttpRequest()){
            $depense = $depenseRepository->findOneBy(['pacc' => $request->get('pacc'), 'activite' => $request->get('activite')]);

            if($depense) return $this->json(['duplicate' => true, 'activite' => $request->get('activite')]);

            $connection->insert('depense', [
                'montant_depense' => $request->get('montant_depense'),
                'activite_id' => $request->get('activite'),
                'pacc_id' => $request->get('pacc')
            ]);

            $depenses = $depenseRepository->findBy(['pacc_id' => $request->get('pacc')]);
            $total_recettes = 0;
            foreach($depenses as $depense){
                $total_recettes += $depense->getMontantDepense();
            }
            $response = $this->renderView("backend/depenses/table_ajax.html.twig", ["depenses" => $depenses, "total_recettes" => $total_recettes]);
            return $this->json($response);
        }else {

            $depense = new Depense();
            $form = $this->createForm(DepensesType::class, $depense);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $depenseRepository->add($depense, true);
                return $this->redirectToRoute('app_depense_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('backend/depenses/new.html.twig', [
                'depense' => $depense,
                'form' => $form,
            ]);
        }
    }

    #[Route('/{id}', name: 'app_depense_show', methods: ['GET'])]
    public function show(Depenses $depense): Response
    {
        return $this->render('backend/depenses/show.html.twig', [
            'depense' => $depense,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_depense_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Depense $depense, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepensesType::class, $depense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_depense_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/depenses/edit.html.twig', [
            'depense' => $depense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_depense_delete', methods: ['POST'])]
    public function delete(Request $request, Depense $depense, EntityManagerInterface $entityManager): Response
    {
        if($request->isXmlHttpRequest()){
            $entityManager->remove($depense);
            $entityManager->flush();
            return $this->json(['result' => 'success']);
        }else{
            if ($this->isCsrfTokenValid('delete'.$depense->getId(), $request->request->get('_token'))) {
                $entityManager->remove($depense);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_depense_index', [], Response::HTTP_SEE_OTHER);
        }

    }
}
