<?php

namespace App\Controller;

use App\Entity\OrganeCoges;
use App\Form\OrganeCogesType;
use App\Helper\DataTableHelper;
use App\Helper\FileUploadHelper;
use App\Repository\OrganeCogesRepository;
use App\Repository\PosteOrganeRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/organecoges')]
class OrganeCogesController extends AbstractController
{
    #[Route('/import-file', name: 'app_organe_coges_import', methods: [ 'GET'])]
    public function importFile(Request $request): Response
    {
        return $this->render('backend/organe_coges/import.html.twig');
    }

    #[Route('/ajax/select2', name: 'app_organe_coges_select2_ajax', methods: ['GET', 'POST'])]
    public function ajaxSelect2(Request $request, PosteOrganeRepository $posteOrganeRepository): JsonResponse
    {
        $organeCoges = $posteOrganeRepository->findAllAjaxSelect2($request->get('search'));
        return $this->json([ "results" => $organeCoges, "pagination" => ["more" => true]]);
    }

    #[Route('/ajax/upload', name: 'app_organe_coges_upload_file_ajax', methods: [ 'POST'])]
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

    #[Route('/process/import-file', name: 'app_organe_coges_proccess_file', methods: ['GET', 'POST'])]
    public function processUploadedFile(Request $request, OrganeCogesRepository $organeCogesRepository): Response
    {
        /* @var UploadedFile $file */
        $file = $request->getSession()->get('user.uploadedfile');
        if($file){
            $fp = fopen($file,'r');
            $header = fgetcsv($fp,null,";");
            while($row = fgetcsv($fp,null,";")){
                $data = array_combine($header, $row);
                $organeCoges = new OrganeCoges();
                if(isset($data['ORGANE COGES'])) {
                    $organeCoges = $organeCogesRepository->findOneBy(['libelle' => $data['ORGANE COGES']]);
                    if($organeCoges) $organeCoges->setOrganeCoges($organeCoges);
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

    #[Route('/', name: 'app_organe_coges_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        return $this->render('backend/organe_coges/index.html.twig');
    }

    #[Route('/datatable', name: 'app_organe_coges_dt', methods: ['GET', 'POST'])]
    public function datatable(Request $request, Connection $connection)
    {
        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'organe_coges';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 'id',
            ],
            [
                'db' => 'libelle_organe',
                'dt' => 'libelle_organe',
            ],
            [
                'db' => 'sigle',
                'dt' => 'sigle',
            ],
        ];

        $sql_details = array(
            'user' => $paramDB['user'],
            'pass' => $paramDB['password'],
            'db'   => $paramDB['dbname'],
            'host' => $paramDB['host']
        );

        $whereResult = '';
        if(!empty($params['libelle_organe_filter'])){
            $whereResult .= " libelle_organe ='". $params['libelle_organe_filter'] . "' AND";
        }

        $whereResult = substr_replace($whereResult,'',-strlen(' AND'));
        $response = DataTableHelper::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult);

        return new JsonResponse($response);
    }

    #[Route('/new', name: 'app_organe_coges_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PosteOrganeRepository $posteOrganeRepository): Response
    {
        $organeCoges = new OrganeCoges();
        $form = $this->createForm(OrganeCogesType::class, $organeCoges);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posteOrganeRepository->add($organeCoges, true);
            if($request->isXmlHttpRequest()) return $this->json([ "success" => 1 ]);
            return $this->redirectToRoute('app_organe_coges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('organe_coges/new.html.twig', [
            'organe_coges' => $organeCoges,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_organe_coges_show', methods: ['GET'])]
    public function show(OrganeCoges $organeCoges): Response
    {
        return $this->render('organe_coges/show.html.twig', [
            'organe_coges' => $organeCoges,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_organe_coges_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OrganeCoges $organeCoges, PosteOrganeRepository $posteOrganeRepository): Response
    {
        $form = $this->createForm(OrganeCogesType::class, $organeCoges);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posteOrganeRepository->add($organeCoges, true);
            if($request->isXmlHttpRequest()) return $this->json([ "success" => 1 ]);
            return $this->redirectToRoute('app_organe_coges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('organe_coges/edit.html.twig', [
            'organe_coges' => $organeCoges,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_organe_coges_delete', methods: ['POST'])]
    public function delete(Request $request, OrganeCoges $organeCoges, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$organeCoges->getId(), $request->request->get('_token'))) {
            $entityManager->remove($organeCoges);
            $entityManager->flush();
        }
        if($request->isXmlHttpRequest()) return $this->json([ "success" => 1 ]);
        return $this->redirectToRoute('app_organe_coges_index', [], Response::HTTP_SEE_OTHER);
    }
}
