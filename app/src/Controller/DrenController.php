<?php

namespace App\Controller;

use App\Entity\Dren;
use App\Form\DrenType;
use App\Helper\DataTableHelper;
use App\Repository\DrenRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/dren')]
class DrenController extends AbstractController
{
    #[Route('/dt', name: 'app_dren_dt', methods: ['GET'])]
    public function listDrenDT(Request $request, Connection $connection, DrenRepository $paymentRepository)
    {
        $user = $this->getUser();

        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'dren';
        $primaryKey = 'id';
        $payment = null;
        $columns = [
            [
                'db' => 'id',
                'dt' => 'DT_RowId',
                'formatter' => function( $d, $row ) {
                    return 'row_'.$d;
                }
            ],
            [
                'db' => 'libelle',
                'dt' => 'libelle',
            ],
            [
                'db' => 'email',
                'dt' => 'email',
            ],
            [
                'db' => 'telephone',
                'dt' => 'telephone',
            ],
            [
                'db' => 'id',
                'dt' => 'id',
                'formatter' => function($d, $row) {
                      return "<a href='/admin/dren/$d/iepp' class='link-info'>IEPP</a>";
                }
            ]
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

    #[Route('/{id}/iepp', name: 'app_dren_iepp_index', methods: ['GET'])]
    public function showDrenIepps(Dren $dren): Response
    {
        $iepps = $dren->getIepps();
        foreach($iepps as $iepp){
            dump($iepp);
        }
        die;
    }
    #[Route('/', name: 'app_dren_index', methods: ['GET'])]
    public function index(DrenRepository $drenRepository): Response
    {
        return $this->render('backend/dren/index.html.twig', [
            'drens' => $drenRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dren_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dren = new Dren();
        $form = $this->createForm(DrenType::class, $dren);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dren);
            $entityManager->flush();

            return $this->redirectToRoute('app_dren_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/dren/new.html.twig', [
            'dren' => $dren,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dren_show', methods: ['GET'])]
    public function show(Dren $dren): Response
    {
        return $this->render('backend/dren/show.html.twig', [
            'dren' => $dren,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dren_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dren $dren, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DrenType::class, $dren);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dren_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/dren/edit.html.twig', [
            'dren' => $dren,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dren_delete', methods: ['POST'])]
    public function delete(Request $request, Dren $dren, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dren->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dren);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dren_index', [], Response::HTTP_SEE_OTHER);
    }



}
