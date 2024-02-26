<?php

namespace App\Controller;

use App\Entity\Coges;
use App\Form\CogesType;
use App\Helper\DataTableHelper;
use App\Helper\FileUploadHelper;
use App\Repository\CogesRepository;
use App\Repository\CommuneRepository;
use App\Repository\DrenRepository;
use App\Repository\IeppRepository;
use App\Repository\MandatCogesRepository;
use App\Repository\MembreOrganeRepository;
use App\Repository\PaccRepository;
use App\Repository\RegionRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/coges')]
class CogesController extends AbstractController
{
    #[Route('/import-file', name: 'app_coges_import', methods: [ 'GET'])]
    public function importFile(Request $request): Response
    {
        return $this->render('backend/coges/import.html.twig');
    }

    #[Route('/ajax/select2', name: 'app_coges_select2_ajax', methods: ['GET', 'POST'])]
    public function ajaxSelect2(Request $request, CogesRepository $cogesRepository): JsonResponse
    {
        $coges = $cogesRepository->findAllAjaxSelect2($request->get('search'));
        return $this->json([ "results" => $coges, "pagination" => ["more" => true]]);
    }

    #[Route('/ajax/upload', name: 'app_coges_upload_file_ajax', methods: [ 'POST'])]
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

    #[Route('/process/import-file', name: 'app_coges_proccess_file', methods: ['GET', 'POST'])]
    public function processUploadedFile(Request $request, CogesRepository $cogesRepository, RegionRepository $regionRepository,
                                        CommuneRepository $communeRepository, DrenRepository $drenRepository,
                                        IeppRepository $ieppRepository): Response
    {
        /* @var UploadedFile $file */
        $file = $request->getSession()->get('user.uploadedfile');
        if($file){
            $fp = fopen($file,'r');
            $header = fgetcsv($fp,null,";");
            while($row = fgetcsv($fp,null,";")){
                $data = array_combine($header, $row);
                $coges = new Coges();
                if(isset($data['IEPP'])) {
                    $iepp = $ieppRepository->findOneBy(['libelle' => $data['IEPP']]);
                    if($iepp) $coges->setIepp($iepp);
                }
                if(isset($data['REGION'])) {
                    $region = $regionRepository->findOneBy(['libelle' => $data['REGION']]);
                    if($region) $coges->setRegion($region);
                }
                if(isset($data['LIBELLE'])) $coges->setLibelle($data['LIBELLE']);
                if(isset($data['DREN'])) {
                    $dren = $drenRepository->findOneBy(['libelle' => $data['DREN']]);
                    if($dren) $coges->setDren($dren);
                }
                if(isset($data['DOMICILIATION'])) $coges->setDomiciliation($data['DOMICILIATION']);
                if(isset($data['CYCLE'])) $coges->setCycle(empty($data['CYCLE'])? null: (int) $data['CYCLE']);
                if(isset($data['COMMUNE'])) {
                    $commune = $communeRepository->findOneBy(['libelle' => $data['COMMUNE']]);
                    if($commune) $coges->setCommune($commune);
                }
                if(isset($data['GROUPE SCOLAIRE'])) $coges->setGroupeScolaire($data['GROUPE SCOLAIRE']);
                if(isset($data['N° COMPTE'])) $coges->setNumeroCompte($data['N° COMPTE']);
                $cogesRepository->add($coges);
            }
            $cogesRepository->flush();
            if(file_exists($file)) unlink($file);
            $request->getSession()->set('user.uploadedfile', null);
            return $this->redirectToRoute('app_coges_index');
        }else{
            return $this->redirectToRoute('app_coges_index');
        }
    }

    #[Route('/', name: 'app_coges_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        return $this->render('backend/coges/index.html.twig');
    }

    #[Route('/datatable', name: 'app_coges_dt', methods: ['GET', 'POST'])]
    public function datatable(Request $request, Connection $connection)
    {
        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'coges';
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
                'db' => 'cycle',
                'dt' => 'cycle',
            ],
            [
                'db' => 'numero_compte',
                'dt' => 'numero_compte'
            ],
            [
                'db' => 'domiciliation',
                'dt' => 'domiciliation'
            ],
            [
                'db' => 'groupe_scolaire',
                'dt' => 'groupe_scolaire',
                'formatter' => function($d, $row){
                    $content = sprintf("<input class='form-check-input' type='checkbox' role='switch' id='groupe_scolaire' name='groupe_scolaire' disabled %s>", $d ? 'checked': '');
                    return $content;
                }
            ],
            [
                'db' => 'id',
                'dt' => '',
                'formatter' => function($d, $row){
                    $coges_id = $row['id'];
                    $content = sprintf("<div class='d-flex'><a href='/admin/coges/%s' class='btn btn-light shadow btn-xs sharp me-1' data-coges-id='%s'><i class='fa fa-eye'></i></a><span class='btn btn-primary shadow btn-xs sharp me-1' data-coges-id='%s'><i class='fa fa-pencil'></i></span><span data-coges-id='%s' class='btn btn-danger shadow btn-xs sharp'><i class='fa fa-trash'></i></span></div>",$coges_id,$coges_id, $coges_id, $coges_id);
                    return $content;
                }
            ]
        ];

        $sql_details = array(
            'user' => $paramDB['user'],
            'pass' => $paramDB['password'],
            'db'   => $paramDB['dbname'],
            'host' => $paramDB['host']
        );

        $whereResult = '';
        if(!empty($params['commune_filter'])){
            $whereResult .= " commune_id ='". $params['commune_filter'] . "' AND";
        }
        if(!empty($params['region_filter'])){
            $whereResult .= " region_id ='". $params['region_filter'] . "' AND";
        }
        if(!empty($params['dren_filter'])){
            $whereResult .= " dren_id ='". $params['dren_filter'] . "' AND";
        }
        if(!empty($params['iepp_filter'])){
            $whereResult .= " iepp_id = '". $params['iepp_filter'] . "' AND";
        }

        $whereResult = substr_replace($whereResult,'',-strlen(' AND'));
        $response = DataTableHelper::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult);

        return new JsonResponse($response);
    }

    #[Route('/ajax/new', name: 'app_coges_new_ajax', methods: ['GET', 'POST'])]
    public function newAjax(Request $request, EntityManagerInterface $entityManager): Response
    {
        if($request->isXmlHttpRequest()) {
            $data = array_filter($request->request->all(), function($d) {
                return !empty($d);
            });
            if(array_key_exists('groupe_scolaire', $data)) $data['groupe_scolaire'] = $data['groupe_scolaire'] === 'on' ? 1:0;
            $connection = $entityManager->getConnection();
            $connection->insert('coges', $data);
            return $this->json('saved');
        }

        return $this->json('error');
    }

    #[Route('/new', name: 'app_coges_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CogesRepository $cogesRepository, EntityManagerInterface $entityManager): Response
    {

        $coge = new Coges();
        $form = $this->createForm(CogesType::class, $coge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cogesRepository->add($coge);

            return $this->redirectToRoute('app_coges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/coges/new.html.twig', [
            'coge' => $coge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_coges_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Coges $coges, MandatCogesRepository $mandatCogesRepository,
                         MembreOrganeRepository $membreOrganeRepository,
                         PaccRepository $paccRepository): Response
    {
        $mandat = $mandatCogesRepository->findBy(['coges' => $coges], ['DateDebut' => 'desc'], 1);
        $pacc = $paccRepository->findBy(['mandatCoges' => $mandat], ['dateDebut' => 'desc'], 1);
        $membres = $membreOrganeRepository->findBy(['mandat' => $mandat]);
        return $this->render('backend/coges/show.html.twig', [
            'coge' => $coges,
            'mandat' => $mandat ? $mandat[0]: null,
            'pacc' => $pacc ? $pacc[0]: null,
            'membres' => $membres

        ]);
    }

    #[Route('/{id}/edit', name: 'app_coges_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
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

    #[Route('/{id}', name: 'app_coges_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Coges $coge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coge->getId(), $request->request->get('_token'))) {
            $entityManager->remove($coge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_coges_index', [], Response::HTTP_SEE_OTHER);
    }

}
