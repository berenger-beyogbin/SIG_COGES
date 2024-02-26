<?php

namespace App\Controller;

use App\Entity\MembreOrgane;
use App\Entity\PosteOrgane;
use App\Form\MembreOrganeType;
use App\Helper\DataTableHelper;
use App\Helper\FileUploadHelper;
use App\Repository\MandatCogesRepository;
use App\Repository\MembreOrganeRepository;
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

#[Route('/admin/membreorgane')]
class MembreOrganeController extends AbstractController
{
    #[Route('/import-file', name: 'app_membre_organe_import', methods: [ 'GET'])]
    public function importFile(Request $request): Response
    {
        return $this->render('backend/membre_organe/import.html.twig');
    }

    #[Route('/ajax/select2', name: 'app_membre_organe_select2_ajax', methods: ['GET', 'POST'])]
    public function ajaxSelect2(Request $request, MembreOrganeRepository $membreOrganeRepository): JsonResponse
    {
        $membreOrgane = $membreOrganeRepository->findAllAjaxSelect2($request->get('search'));
        return $this->json([ "results" => $membreOrgane, "pagination" => ["more" => true]]);
    }

    #[Route('/ajax/new', name: 'app_membre_organe_new_ajax', methods: ['GET', 'POST'])]
    public function newAjax(Request $request, EntityManagerInterface $entityManager): Response
    {
        if($request->isXmlHttpRequest()) {
            $data = array_filter($request->request->all(), function($d) {
                return !empty($d);
            });
            $connection = $entityManager->getConnection();
            $connection->insert('membre_organe', $data);
            return $this->json('saved');
        }

        return $this->json('error');
    }


    #[Route('/ajax/upload', name: 'app_membre_organe_upload_file_ajax', methods: [ 'POST'])]
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

    #[Route('/process/import-file', name: 'app_membre_organe_proccess_file', methods: ['GET', 'POST'])]
    public function processUploadedFile(Request $request,MembreOrganeRepository $membreOrganeRepository, PosteOrganeRepository $posteOrganeRepository, MandatCogesRepository $mandatCogesRepository): Response
    {
        /* @var UploadedFile $file */
        $file = $request->getSession()->get('user.uploadedfile');
        if($file){
            $fp = fopen($file,'r');
            $header = fgetcsv($fp,null,";");
            while($row = fgetcsv($fp,null,";")){
                $data = array_combine($header, $row);
                $membreOrgane = new MembreOrgane();
                if(isset($data['POSTE ORGANE'])) {
                    $posteOrgane = $posteOrganeRepository->findOneBy(['libelle' => $data['POSTE ORGANE']]);
                    if($posteOrgane) $membreOrgane->setPoste($posteOrgane);
                }
                if(isset($data['MANDAT COGES'])) {
                    $mandatCoges = $mandatCogesRepository->findOneBy(['id' => $data['MANDAT COGES']]);
                    if($mandatCoges) $membreOrgane->setMandat($mandatCoges);
                }
            }
            $membreOrganeRepository->flush();
            if(file_exists($file)) unlink($file);
            $request->getSession()->set('user.uploadedfile', null);
            return $this->redirectToRoute('app_membre_organe_index');
        }else{
            return $this->redirectToRoute('app_membre_organe_index');
        }
    }


    #[Route('/datatable', name: 'app_membre_organe_dt', methods: ['GET', 'POST'])]
    public function datatable(Request $request, Connection $connection)
    {
        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'membre_organe';
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
                'db' => 'prenoms',
                'dt' => 'prenoms',
            ],
            [
                'db' => 'profession',
                'dt' => 'profession',
            ],
            [
                'db' => 'contact',
                'dt' => 'contact',
            ],
            [
                'db' => 'poste_id',
                'dt' => 'poste_id'
            ],
            [
                'db' => 'mandat_id',
                'dt' => 'mandat_id'
            ],
            [
                'db' => 'id',
                'dt' => 'id',
                'formatter' => function($d, $row){
                    $membre_organe_id = $row['id'];
                    $content = sprintf("<div class='d-flex'><span class='btn btn-primary shadow btn-xs sharp me-1' data-membre_organe-id='%s'><i class='fa fa-pencil'></i></span><span data-membre_organe-id='%s' class='btn btn-danger shadow btn-xs sharp'><i class='fa fa-trash'></i></span></div>", $membre_organe_id, $membre_organe_id);
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

        if(!empty($params['coges_filter'])){
            $whereResult .= " coges_id ='". $params['coges_filter'] . "' AND";
        }
        if($whereResult) $whereResult = substr_replace($whereResult,'',-strlen(' AND'));

        $response = DataTableHelper::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult);

        return new JsonResponse($response);
    }
    #[Route('/', name: 'app_membre_organe_index', methods: ['GET'])]
    public function index(MembreOrganeRepository $membreOrganeRepository): Response
    {
        return $this->render('backend/membre_organe/index.html.twig');
    }

    #[Route('/new', name: 'app_membre_organe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $membreOrgane = new MembreOrgane();
        $form = $this->createForm(MembreOrganeType::class, $membreOrgane);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($membreOrgane);
            $entityManager->flush();

            return $this->redirectToRoute('app_membre_organe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/membre_organe/new.html.twig', [
            'membre_organe' => $membreOrgane,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_membre_organe_show', methods: ['GET'])]
    public function show(MembreOrgane $membreOrgane): Response
    {
        return $this->render('backend/membre_organe/show.html.twig', [
            'membre_organe' => $membreOrgane,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_membre_organe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MembreOrgane $membreOrgane, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MembreOrganeType::class, $membreOrgane);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_membre_organe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/membre_organe/edit.html.twig', [
            'membre_organe' => $membreOrgane,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_membre_organe_delete', methods: ['POST'])]
    public function delete(Request $request, MembreOrgane $membreOrgane, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membreOrgane->getId(), $request->request->get('_token'))) {
            $entityManager->remove($membreOrgane);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_membre_organe_index', [], Response::HTTP_SEE_OTHER);
    }
}
