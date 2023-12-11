<?php

namespace App\Controller;

use App\Entity\Gratification;
use App\Helper\DataTableHelper;
use App\Repository\GratificationRepository;
use App\Service\Gratification\GratificationService;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GratificationController extends AbstractController
{
    #[Route('/', name: 'gratification_index', methods: ['GET'])]
    public function index(GratificationRepository $gratificationRepository): Response
    {
        return $this->render('gratifications/pages/index.html.twig', [
            'gratifications' => $gratificationRepository->findAll(),
        ]);
    }

    #[Route('/upload', name: 'gratification_upload', methods: ['POST'])]
    public function upload(Request $request, GratificationService $gratificationService): Response
    {
        $file = $request->files->get('fichier');
        $annee = $request->get('annee');
        $mois = $request->get('mois');
        $gratificationService->processFile($annee, $mois, $file);
        return $this->redirectToRoute('gratification_show');
    }

    #[Route('/show', name: 'gratification_show', methods: ['GET'])]
    public function show(Request $request, GratificationService $gratificationService): Response
    {
        return $this->render('gratifications/pages/table.html.twig');
    }

    #[Route('/datatable', name: 'gratification_datatable', methods: ['GET'])]
    public function datatable(Request $request,
                              Connection $connection,
                              )
    {
        date_default_timezone_set("Africa/Abidjan");
        $paramDB = $connection->getParams();
        $table = 'gratification';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 'id',
            ],
            [
                'db' => 'matricule',
                'dt' => 'matricule',
            ],
            [
                'db' => 'fullname',
                'dt' => 'fullname',
            ],
            [
                'db' => 'fonction',
                'dt' => 'fonction',
            ],
            [
                'db' => 'janvier',
                'dt' => 'janvier',
            ],
            [
                'db' => 'fevrier',
                'dt' => 'fevrier'
            ],
            [
                'db' => 'mars',
                'dt' => 'mars'
            ],
            [
                'db' => 'avril',
                'dt' => 'avril'
            ],
            [
                'db' => 'mai',
                'dt' => 'mai'
            ],
            [
                'db' => 'juin',
                'dt' => 'juin'
            ],
            [
                'db' => 'juillet',
                'dt' => 'juillet'
            ],
            [
                'db' => 'aout',
                'dt' => 'aout'
            ],
            [
                'db' => 'septembre',
                'dt' => 'septembre'
            ],
            [
                'db' => 'octobre',
                'dt' => 'octobre'
            ],
            [
                'db' => 'novembre',
                'dt' => 'novembre'
            ],
            [
                'db' => 'decembre',
                'dt' => 'decembre'
            ],

        ];

        $sql_details = array(
            'user' => $paramDB['user'],
            'pass' => $paramDB['password'],
            'db'   => $paramDB['dbname'],
            'host' => $paramDB['host']
        );

        $response = DataTableHelper::complex($_GET, $sql_details, $table, $primaryKey, $columns);

        return new JsonResponse($response);
    }

}
