<?php

namespace App\Controller;

use App\Entity\Coges;
use App\Form\CogesType;
use App\Helper\DataTableHelper;
use App\Repository\CogesRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/coges')]
class CogesController extends AbstractController
{
    #[Route('/dt', name: 'app_coges_dt', methods: ['GET'])]
    public function listCogesDT(Request $request, Connection $connection, CogesRepository $cogesRepository)
    {
        $user = $this->getUser();

        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'coges';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 'DT_RowId',
                'formatter' => function( $d, $row ) {
                    return 'row_'.$d;
                }
            ],
            [
                'db' => 'libelle_coges',
                'dt' => 'libelle_coges',
            ],
            [
                'db' => 'cycle',
                'dt' => 'cycle',
            ],
            [
                'db' => 'numero_compte',
                'dt' => 'numero_compte',
            ],
            [
                'db' => 'domiciliation',
                'dt' => 'domiciliation',
            ],
            [
                'db' => 'groupe_scolaire',
                'dt' => 'groupe_scolaire',
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

    #[Route('/', name: 'app_coges_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('backend/coges/index.html.twig');
    }

    #[Route('/new', name: 'app_coges_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $coge = new Coges();
        $form = $this->createForm(CogesType::class, $coge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($coge);
            $entityManager->flush();

            return $this->redirectToRoute('app_coges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/coges/new.html.twig', [
            'coge' => $coge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_coges_show', methods: ['GET'])]
    public function show(Coges $coge): Response
    {
        return $this->render('backend/coges/show.html.twig', [
            'coge' => $coge,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_coges_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Coges $coge, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CogesType::class, $coge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_coges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/coges/edit.html.twig', [
            'coge' => $coge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_coges_delete', methods: ['POST'])]
    public function delete(Request $request, Coges $coge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coge->getId(), $request->request->get('_token'))) {
            $entityManager->remove($coge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_coges_index', [], Response::HTTP_SEE_OTHER);
    }


}
