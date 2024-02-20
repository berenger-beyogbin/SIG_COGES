<?php

namespace App\Controller;

use App\Entity\Coges;
use App\Entity\Commune;
use App\Entity\Region;
use App\Form\CommuneType;
use App\Helper\DataTableHelper;
use App\Helper\FileUploadHelper;
use App\Repository\CommuneRepository;
use App\Repository\RegionRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/commune')]
class CommuneController extends AbstractController
{
    #[Route('/import-file', name: 'app_commune_import', methods: [ 'GET'])]
    public function importFile(Request $request): Response
    {
        return $this->render('backend/commune/import.html.twig');
    }

    #[Route('/ajax/upload', name: 'app_commune_upload_file_ajax', methods: [ 'POST'])]
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


    #[Route('/ajax/select2', name: 'app_commune_select2_ajax', methods: ['GET', 'POST'])]
    public function ajaxSelect2(Request $request, CommuneRepository $communeRepository): JsonResponse
    {
        $communes = $communeRepository->findAllAjaxSelect2($request->get('search'));
        return $this->json([ "results" => $communes, "pagination" => ["more" => true]]);
    }

    #[Route('/process/import-file', name: 'app_commune_proccess_file', methods: ['GET', 'POST'])]
    public function processUploadedFile(Request $request,
                                        CommuneRepository $communeRepository,
                                        RegionRepository $regionRepository): Response
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
            return $this->redirectToRoute('app_commune_index');
        }else{
            return $this->redirectToRoute('app_commune_index');
        }
    }

    #[Route('/ajax/new', name: 'app_commune_new_ajax', methods: ['GET', 'POST'])]
    public function newAjax(Request $request, EntityManagerInterface $entityManager): Response
    {
        if($request->isXmlHttpRequest()) {
            $data = array_filter($request->request->all(),function($d) {
                return !empty($d);
            });
            $connection = $entityManager->getConnection();
            $connection->insert('commune', $data);
            return $this->json('saved');
        }
        return $this->json('error');
    }

    #[Route('/datatable', name: 'app_commune_dt', methods: ['GET', 'POST'])]
    public function datatable(Request $request,
                              Connection $connection)
    {
        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'view_commune_region';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 'id',
            ],
            [
                'db' => 'libelle',
                'dt' => 'libelle',
            ],
            [
                'db' => 'description',
                'dt' => 'description',
            ],
            [
                'db' => 'region',
                'dt' => 'region',
                'formatter' => function($d, $row){
                    return sprintf("<a href='/admin/region/%s' class='link-info'>%s</a>", $row['region_id'], $d);
                }
            ],
            [
                'db' => 'region_id',
                'dt' => 'region_id',
                'formatter' => function($d, $row){
                    $commune_id = $row['id'];
                    $content = sprintf("<div class='d-flex'><span class='btn btn-primary shadow btn-xs sharp me-1' data-commune-id='%s'><i class='fa fa-pencil'></i></span><span data-commune-id='%s' class='btn btn-danger shadow btn-xs sharp'><i class='fa fa-trash'></i></span></div>", $commune_id, $commune_id);
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

        $whereResult = '';
        if(!empty($params['commune_filter'])){
            $whereResult .= " id ='". $params['commune_filter'] . "' AND";
        }
        if(!empty($params['region_filter'])){
            $whereResult .= " region_id ='". $params['region_filter'] . "' AND";
        }

        $whereResult = substr_replace($whereResult,'',-strlen(' AND'));
        $response = DataTableHelper::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult);

        return new JsonResponse($response);
    }
    #[Route('/', name: 'app_commune_index', methods: ['GET','POST'])]
    public function index(Request $request,
                          CommuneRepository $communeRepository,
                          RegionRepository $regionRepository): Response
    {
        return $this->render('backend/commune/index.html.twig', [
            'regions' => $regionRepository->findAll(),
            'communes' => $communeRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_commune_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commune = new Commune();
        $form = $this->createForm(CommuneType::class, $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commune);
            $entityManager->flush();

            return $this->redirectToRoute('app_commune_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/commune/new.html.twig', [
            'commune' => $commune,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commune_show', methods: ['GET'])]
    public function show(Commune $commune): Response
    {
        return $this->render('backend/commune/show.html.twig', [
            'commune' => $commune,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commune_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commune $commune, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommuneType::class, $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commune_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/commune/edit.html.twig', [
            'commune' => $commune,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commune_delete', methods: ['POST'])]
    public function delete(Request $request, Commune $commune, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commune->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commune);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commune_index', [], Response::HTTP_SEE_OTHER);
    }



}
