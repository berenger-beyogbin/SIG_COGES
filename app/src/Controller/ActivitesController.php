<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Activites;
use App\Form\ActivitesType;
use App\Helper\DataTableHelper;
use App\Repository\ActiviteRepository;
use App\Repository\CogesRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/activites')]
class ActivitesController extends AbstractController
{
    #[Route('/dt', name: 'app_activites_dt', methods: ['GET'])]
    public function listActivitesDT(Request $request, Connection $connection, ActiviteRepository $activitesRepository)
    {
        $user = $this->getUser();

        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'activite';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 'id'
            ],
            [
                'db' => 'libelle_activite',
                'dt' => 'libelle_activite',
            ],
            [
                'db' => 'id',
                'dt' => '',
                'formatter' => function($d, $row){
                    $content = sprintf("<div class='d-flex'><span class='btn btn-warning shadow btn-xs sharp me-1' data-activite-id='%s'><i class='fa fa-pencil'></i></span><span data-activite-id='%s' class='btn btn-danger shadow btn-xs sharp'><i class='fa fa-trash'></i></span></div>", $d, $d);
                    return $content;
                }
            ],
        ];

        $sql_details = array(
            'user' => $paramDB['user'],
            'pass' => $paramDB['password'],
            'db'   => $paramDB['dbname'],
            'host' => $paramDB['host']
        );

        $whereResult =  null;
        $response = DataTableHelper::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $whereResult);
        return new JsonResponse($response);
    }

    #[Route('/', name: 'app_activites_index', methods: ['GET'])]
    public function index(ActiviteRepository $activitesRepository): Response
    {
        return $this->render('backend/activites/index.html.twig', [
            'activites' => $activitesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_activites_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activite = new Activite();
        $form = $this->createForm(ActivitesType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($activite);
            $entityManager->flush();

            return $this->redirectToRoute('app_activites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/activites/new.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_activites_show', methods: ['GET'])]
    public function show(Activites $activite): Response
    {
        return $this->render('backend/activites/show.html.twig', [
            'activite' => $activite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_activites_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activites $activite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActivitesType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_activites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/activites/edit.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_activites_delete', methods: ['POST'])]
    public function delete(Request $request, Activites $activite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($activite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_activites_index', [], Response::HTTP_SEE_OTHER);
    }
}
