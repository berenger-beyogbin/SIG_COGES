<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseursType;
use App\Helper\DataTableHelper;
use App\Repository\FournisseurRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/fournisseurs')]
class FournisseursController extends AbstractController
{
    #[Route('/', name: 'app_fournisseurs_index', methods: ['GET'])]
    public function index(FournisseurRepository $fournisseursRepository): Response
    {
        return $this->render('backend/fournisseurs/index.html.twig', [
            'fournisseurs' => $fournisseursRepository->findAll(),
        ]);
    }

    #[Route('/datatable', name: 'app_fournisseurs_dt', methods: ['GET', 'POST'])]
    public function datatable(Request $request, Connection $connection)
    {
        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'fournisseur';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 'id',
            ],
            [
                'db' => 'entreprise',
                'dt' => 'entreprise',
            ],
            [
                'db' => 'nom',
                'dt' => 'nom',
            ],
            [
                'db' => 'Prenoms',
                'dt' => 'Prenoms',
            ],
            [
                'db' => 'contact',
                'dt' => 'contact',
            ],

            [
                'db' => 'domaine_activite',
                'dt' => 'domaine_activite',
            ],
            [
                'db' => 'domiciliation',
                'dt' => 'domiciliation',
            ],
            [
                'db' => 'localite',
                'dt' => 'localite',
            ],
            [
                'db' => 'id',
                'dt' => '',
                'formatter' => function($id, $row){
                    $content = sprintf("<div class='d-flex'><span class='btn btn-warning shadow btn-xs sharp me-1 btn-edit' data-id='%s'><i class='fa fa-pencil'></i></span><span data-id='%s' class='btn btn-danger shadow btn-xs sharp  btn-delete'><i class='fa fa-trash'></i></span></div>", $id, $id);
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

        $whereResult = null;

        if($whereResult) $whereResult = substr_replace($whereResult,'',-strlen(' AND'));

        $response = DataTableHelper::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult);

        return new JsonResponse($response);
    }

    #[Route('/new', name: 'app_fournisseurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FournisseurRepository $fournisseursRepository): Response
    {
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseursType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseursRepository->add($fournisseur, true);
            if($request->isXmlHttpRequest()) return $this->json([ "success" => 1 ]);

            return $this->redirectToRoute('app_fournisseurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/fournisseurs/new.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fournisseurs_show', methods: ['GET'])]
    public function show(Fournisseur $fournisseur): Response
    {
        return $this->render('backend/fournisseurs/show.html.twig', [
            'fournisseur' => $fournisseur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fournisseurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fournisseur $fournisseur, FournisseurRepository $fournisseursRepository): Response
    {
        $form = $this->createForm(FournisseursType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseursRepository->add($fournisseur, true);
            if($request->isXmlHttpRequest()) return $this->json([ "success" => 1 ]);
            return $this->redirectToRoute('app_fournisseurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/fournisseurs/edit.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fournisseurs_delete', methods: ['POST'])]
    public function delete(Request $request, Fournisseur $fournisseur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fournisseur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fournisseur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_fournisseurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
