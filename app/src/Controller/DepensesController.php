<?php

namespace App\Controller;

use App\Entity\Depense;
use App\Form\DepensesType;
use App\Helper\DataTableHelper;
use App\Repository\DepenseRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route('/datatable', name: 'app_depense_dt', methods: ['GET', 'POST'])]
    public function datatable(Request $request, Connection $connection)
    {
        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'depense';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 'id',
            ],
            [
                'db' => 'activite_id',
                'dt' => 'activite_id',
                'formatter' => function($d, $row) use($connection) {
                    $res = $connection->fetchOne('select libelle_activite from activite where id = :p', ['p' => $d]);
                    return "<span>$res</span>";
                }
            ],
            [
                'db' => 'montant_depense',
                'dt' => 'montant_depense',
            ],
            [
                'db' => 'id',
                'dt' => '',
                'formatter' => function($d, $row){
                    $content = sprintf("<div class='d-flex justify-content-end'><span class='btn btn-warning shadow btn-xs sharp me-1' data-recette-id='%s'><i class='fa fa-pencil'></i></span><span data-recette-id='%s' class='btn btn-danger shadow btn-xs sharp'><i class='fa fa-trash'></i></span></div>", $d, $d);
                    return $content;
                }
            ],
        ];

        $sql_details = [
            'user' => $paramDB['user'],
            'pass' => $paramDB['password'],
            'db'   => $paramDB['dbname'],
            'host' => $paramDB['host']
        ];

        $whereResult = null;

        if(!empty($params['source_filter'])) {
            $whereResult .= " source_id = '". $params['source_filter'] . "' AND";
        }
        if(!empty($params['pacc_filter'])) {
            $whereResult .= " pacc_id = '". $params['pacc_filter'] . "' AND";
        }

        if($whereResult) $whereResult = substr_replace($whereResult,'',-strlen(' AND'));

        $response = DataTableHelper::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult);

        return new JsonResponse($response);
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

            $depenses = $depenseRepository->findBy(['pacc' => $request->get('pacc')]);
            $total_depenses = 0;
            foreach($depenses as $depense){
                $total_depenses += $depense->getMontantDepense();
            }
            return $this->json(['total_depenses' => $total_depenses,'duplicate' => false]);
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
    public function show(Depense $depense): Response
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
