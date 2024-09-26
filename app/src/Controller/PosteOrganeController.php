<?php

namespace App\Controller;

use App\Entity\Coges;
use App\Entity\OrganeCoges;
use App\Entity\PosteOrgane;
use App\Form\PosteOrganeType;
use App\Helper\DataTableHelper;
use App\Helper\FileUploadHelper;
use App\Repository\CogesRepository;
use App\Repository\CommuneRepository;
use App\Repository\DrenRepository;
use App\Repository\IeppRepository;
use App\Repository\OrganeCogesRepository;
use App\Repository\PosteOrganeRepository;
use App\Repository\RegionRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/posteorgane')]
class PosteOrganeController extends AbstractController
{
    #[Route('/import-file', name: 'app_poste_organe_import', methods: [ 'GET'])]
    public function importFile(Request $request): Response
    {
        return $this->render('backend/poste_organe/import.html.twig');
    }

    #[Route('/ajax/select2', name: 'app_poste_organe_select2_ajax', methods: ['GET', 'POST'])]
    public function ajaxSelect2(Request $request, PosteOrganeRepository $posteOrganeRepository): JsonResponse
    {
        $posteOrgane = $posteOrganeRepository->findAllAjaxSelect2($request->get('search'));
        return $this->json([ "results" => $posteOrgane, "pagination" => ["more" => true]]);
    }

    #[Route('/ajax/upload', name: 'app_poste_organe_upload_file_ajax', methods: [ 'POST'])]
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

    #[Route('/process/import-file', name: 'app_poste_organe_proccess_file', methods: ['GET', 'POST'])]
    public function processUploadedFile(Request $request, OrganeCogesRepository $organeCogesRepository): Response
    {
        /* @var UploadedFile $file */
        $file = $request->getSession()->get('user.uploadedfile');
        if($file){
            $fp = fopen($file,'r');
            $header = fgetcsv($fp,null,";");
            while($row = fgetcsv($fp,null,";")){
                $data = array_combine($header, $row);
                $posteOrgane = new PosteOrgane();
                if(isset($data['ORGANE COGES'])) {
                    $organeCoges = $organeCogesRepository->findOneBy(['libelle' => $data['ORGANE COGES']]);
                    if($organeCoges) $posteOrgane->setOrganeCoges($organeCoges);
                }
            }
            $organeCogesRepository->flush();
            if(file_exists($file)) unlink($file);
            $request->getSession()->set('user.uploadedfile', null);
            return $this->redirectToRoute('app_coges_index');
        }else{
            return $this->redirectToRoute('app_coges_index');
        }
    }

    #[Route('/', name: 'app_poste_organe_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        return $this->render('backend/poste_organe/index.html.twig');
    }

    #[Route('/datatable', name: 'app_poste_organe_dt', methods: ['GET', 'POST'])]
    public function datatable(Request $request, Connection $connection)
    {
        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'poste_organe';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 'id',
            ],
            [
                'db' => 'libelle_poste',
                'dt' => 'libelle_poste',
            ],
            [
                'db' => 'organe_coges_id',
                'dt' => 'organe_coges_id',
            ],
        ];

        $sql_details = array(
            'user' => $paramDB['user'],
            'pass' => $paramDB['password'],
            'db'   => $paramDB['dbname'],
            'host' => $paramDB['host']
        );

        $whereResult = '';
        if(!empty($params['libelle_filter'])){
            $whereResult .= " libelle_poste ='". $params['libelle_filter'] . "' AND";
        }
        if(!empty($params['organe_filter'])){
            $whereResult .= " organe_coges_id ='". $params['organe_filter'] . "' AND";
        }

        $whereResult = substr_replace($whereResult,'',-strlen(' AND'));
        $response = DataTableHelper::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult);

        return new JsonResponse($response);
    }

    #[Route('/new', name: 'app_poste_organe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PosteOrganeRepository $posteOrganeRepository): Response
    {
        $posteOrgane = new PosteOrgane();
        $form = $this->createForm(PosteOrganeType::class, $posteOrgane);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posteOrganeRepository->add($posteOrgane, true);
            if($request->isXmlHttpRequest()) return $this->json([ "success" => 1 ]);
            return $this->redirectToRoute('app_poste_organe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('poste_organe/new.html.twig', [
            'poste_organe' => $posteOrgane,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_poste_organe_show', methods: ['GET'])]
    public function show(PosteOrgane $posteOrgane): Response
    {
        return $this->render('poste_organe/show.html.twig', [
            'poste_organe' => $posteOrgane,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_poste_organe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PosteOrgane $posteOrgane, PosteOrganeRepository $posteOrganeRepository): Response
    {
        $form = $this->createForm(PosteOrganeType::class, $posteOrgane);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posteOrganeRepository->add($posteOrgane, true);
            if($request->isXmlHttpRequest()) return $this->json([ "success" => 1 ]);
            return $this->redirectToRoute('app_poste_organe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('poste_organe/edit.html.twig', [
            'poste_organe' => $posteOrgane,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_poste_organe_delete', methods: ['POST'])]
    public function delete(Request $request, PosteOrgane $posteOrgane, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$posteOrgane->getId(), $request->request->get('_token'))) {
            $entityManager->remove($posteOrgane);
            $entityManager->flush();
        }
        if($request->isXmlHttpRequest()) return $this->json([ "success" => 1 ]);
        return $this->redirectToRoute('app_poste_organe_index', [], Response::HTTP_SEE_OTHER);
    }
}
