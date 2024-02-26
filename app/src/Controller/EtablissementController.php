<?php

namespace App\Controller;

use App\Entity\Commune;
use App\Entity\Etablissement;
use App\Form\EtablissementType;
use App\Helper\DataTableHelper;
use App\Helper\FileUploadHelper;
use App\Repository\CogesRepository;
use App\Repository\CommuneRepository;
use App\Repository\DrenRepository;
use App\Repository\EtablissementRepository;
use App\Repository\IeppRepository;
use App\Repository\RegionRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/etablissement')]
class EtablissementController extends AbstractController
{

    #[Route('/import-file', name: 'app_etablissement_import', methods: [ 'GET'])]
    public function importFile(Request $request): Response
    {
        return $this->render('backend/etablissement/import.html.twig');
    }

    #[Route('/ajax/select2', name: 'app_etablissement_select2_ajax', methods: ['GET', 'POST'])]
    public function ajaxSelect2(Request $request, EtablissementRepository $etablissementRepository): JsonResponse
    {
        $etablissements = $etablissementRepository->findAllAjaxSelect2($request->get('search'));
        return $this->json([ "results" => $etablissements, "pagination" => ["more" => true]]);
    }

    #[Route('/ajax/upload', name: 'app_etablissement_upload_file_ajax', methods: [ 'POST'])]
    public function uploadAjax(Request $request, FileUploadHelper $fileUploadHelper): Response
    {
        /* @var UploadedFile $file */
        if(!empty($file = $request->files->get('file'))){
            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/';
            if(in_array( $file->getMimeType(), ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel','text/csv','text/plain'])){
                $tempFile = $fileUploadHelper->upload($file, $uploadDir);
                $request->getSession()->set('user.uploadedfile', $tempFile->getRealPath());
                return $this->json('uploaded');
            }
        }
        return $this->json('error');
    }

    #[Route('/process/import-file', name: 'app_commune_proccess_file', methods: ['GET', 'POST'])]
    public function processUploadedFile(Request $request, CommuneRepository $communeRepository, RegionRepository $regionRepository): Response
    {
        /* @var UploadedFile $file */
        $file = $request->getSession()->get('user.uploadedfile');
        if($file){
            $fp = fopen($file,'r');
            $header = fgetcsv($fp,null,";");
            while($row = fgetcsv($fp,null,";")){
                $data = array_combine($header, $row);
                $commune = new Commune();
                $commune->setLibelle($data['LIBELLE']);
                if(isset($data['REGION'])) {
                    $region = $regionRepository->findOneBy(['libelle' => $data['REGION']]);
                    if($region) $commune->setRegion($region);
                }
                $communeRepository->add($commune);
            }
            $communeRepository->flush();
            if(file_exists($file)) unlink($file);
            $request->getSession()->set('user.uploadedfile', null);
            return $this->redirectToRoute('app_etablissement_index');
        }else{
            return $this->redirectToRoute('app_etablissement_index');
        }
    }

    #[Route('/ajax/new', name: 'app_etablissement_new_ajax', methods: ['GET', 'POST'])]
    public function newAjax(Request $request, EntityManagerInterface $entityManager): Response
    {
        if($request->isXmlHttpRequest()) {
            $data = array_filter($request->request->all(),function($d) {
                return !empty($d);
            });
            $connection = $entityManager->getConnection();
            $connection->insert('etablissement', $data);
            return $this->json('saved');
        }
        return $this->json('error');
    }

    #[Route('/datatable', name: 'app_etablissement_dt', methods: ['GET', 'POST'])]
    public function datatable(Request $request, Connection $connection)
    {
        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'etablissement';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 'id',
            ],
            [
                'db' => 'nom',
                'dt' => 'nom',
            ],
            [
                'db' => 'localite',
                'dt' => 'localite',
            ],
            [
                'db' => 'type_milieu',
                'dt' => 'type_milieu'
            ],
            [
                'db' => 'cycle',
                'dt' => 'cycle'
            ],
            [
                'db' => 'code_ets',
                'dt' => 'code_ets',
            ],
            [
                'db' => 'id',
                'dt' => '',
                'formatter' => function($d, $row){
                    $etablissement_id = $row['id'];
                    $content = sprintf("<div class='d-flex'><span class='btn btn-light shadow btn-xs sharp me-1' data-etablissement-id='%s'><i class='fa fa-eye'></i></span><span class='btn btn-warning shadow btn-xs sharp me-1' data-etablissement-id='%s'><i class='fa fa-pencil'></i></span><span data-etablissement-id='%s' class='btn btn-danger shadow btn-xs sharp'><i class='fa fa-trash'></i></span></div>", $etablissement_id, $etablissement_id, $etablissement_id);
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

        if(!empty($params['dren_filter'])){
            $whereResult .= " dren_id ='". $params['dren_filter'] . "' AND";
        }

        if(!empty($params['iepp_filter'])){
            $whereResult .= " iepp_id = '". $params['iepp_filter'] . "' AND";
        }

        if(!empty($params['coges_filter'])){
            $whereResult .= " coges_id = '". $params['coges_filter'] . "' AND";
        }

        if($whereResult) $whereResult = substr_replace($whereResult,'',-strlen(' AND'));

        $response = DataTableHelper::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult);

        return new JsonResponse($response);
    }

    #[Route('/', name: 'app_etablissement_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('backend/etablissement/index.html.twig');
    }

    #[Route('/new', name: 'app_etablissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etablissement = new Etablissement();
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etablissement);
            $entityManager->flush();

            return $this->redirectToRoute('app_etablissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/etablissement/new.html.twig', [
            'etablissement' => $etablissement,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_etablissement_show', methods: ['GET'])]
    public function show(Etablissement $etablissement): Response
    {
        return $this->render('backend/etablissement/show.html.twig', [
            'etablissement' => $etablissement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etablissement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etablissement $etablissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etablissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/etablissement/edit.html.twig', [
            'etablissement' => $etablissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etablissement_delete', methods: ['POST'])]
    public function delete(Request $request, Etablissement $etablissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etablissement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etablissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etablissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
