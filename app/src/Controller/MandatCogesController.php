<?php

namespace App\Controller;

use App\Entity\MandatCoges;
use App\Form\MandatCogesType;
use App\Helper\DataTableHelper;
use App\Helper\FileUploadHelper;
use App\Repository\CogesRepository;
use App\Repository\IeppRepository;
use App\Repository\MandatCogesRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/mandatcoges')]
class MandatCogesController extends AbstractController
{
    #[Route('/import-file', name: 'app_mandat_coges_import', methods: ['GET'])]
    public function importFile(Request $request): Response
    {
        return $this->render('backend/mandat_coges/import.html.twig');
    }

    #[Route('/ajax/select2', name: 'app_mandatcoges_select2_ajax', methods: ['GET', 'POST'])]
    public function ajaxSelect2(Request $request, MandatCogesRepository $mandatCogesRepository): JsonResponse
    {
        $mandatCoges = $mandatCogesRepository->findAllAjaxSelect2($request->get('search'));
        return $this->json([ "results" => $mandatCoges, "pagination" => ["more" => true]]);
    }


    #[Route('/ajax/upload', name: 'app_mandat_coges_upload_file_ajax', methods: ['POST'])]
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

    #[Route('/process/import-file', name: 'app_mandat_coges_proccess_file', methods: ['GET', 'POST'])]
    public function processUploadedFile(Request $request,
                                        MandatCogesRepository $mandatCogesRepository): Response
    {
        /* @var UploadedFile $file */
        $file = $request->getSession()->get('user.uploadedfile');
        if($file){
            $fp = fopen($file,'r');
            $header = fgetcsv($fp,null,";");
            while($row = fgetcsv($fp,null,";")){
                $data = array_combine($header, $row);
                $mandatCoges = new MandatCoges();
                if(isset($data['DATE_DEBUT'])) $mandatCoges->setDateDebut($data['DATE_DEBUT']);
                if(isset($data['DATE_FIN'])) $mandatCoges->setDateFin($data['DATE_FIN']);
                if(isset($data['COGES'])) $mandatCoges->setCoges($data['COGES']);
                $mandatCogesRepository->add($mandatCoges);
            }
            $mandatCogesRepository->flush();
            if(file_exists($file)) unlink($file);
            $request->getSession()->set('user.uploadedfile', null);
            return $this->redirectToRoute('app_mandat_coges_index');
        }else{
            return $this->redirectToRoute('app_mandat_coges_index');
        }
    }

    #[Route('/datatable', name: 'app_mandat_coges_dt', methods: ['GET', 'POST'])]
    public function datatable(Request $request,
                              Connection $connection)
    {
        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'mandat_coges';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 'id',
            ],
            [
                'db' => 'date_debut',
                'dt' => 'date_debut',
                'formatter' => function($d, $row){
                    $date = date('d/m/Y', strtotime($d));
                    return "<span>$date</span>";
                }
            ],
            [
                'db' => 'date_fin',
                'dt' => 'date_fin',
                'formatter' => function($d, $row){
                    $date = date('d/m/Y', strtotime($d));
                    return "<span>$date</span>";
                }
            ],
            [
                'db' => 'id',
                'dt' => '',
                'formatter' => function($d, $row){
                    $mandat_coges_id = $row['id'];
                    $content = sprintf("<div class='d-flex'><span class='btn btn-warning shadow btn-xs sharp me-1 btn-mandat-coges-edit' data-id='%s'><i class='fa fa-pencil'></i></span><span data-id='%s' class='btn btn-danger shadow btn-xs sharp btn-mandat-coges-delete'><i class='fa fa-trash'></i></span></div>", $mandat_coges_id, $mandat_coges_id);
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
    #[Route('/', name: 'app_mandat_coges_index', methods: ['GET','POST'])]
    public function index(Request $request): Response
    {
        return $this->render('backend/mandat_coges/index.html.twig');
    }

    #[Route('/new', name: 'app_mandat_coges_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MandatCogesRepository $mandatCogesRepository, CogesRepository $cogesRepository): Response
    {
        $mandatCoge = new MandatCoges();

        if($request->get('coges')) {
            $coges = $cogesRepository->find($request->get('coges'));
            if($coges) $mandatCoge->setCoges($coges);
        }

        $form = $this->createForm(MandatCogesType::class, $mandatCoge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mandatCogesRepository->add($mandatCoge, true);
            if($request->isXmlHttpRequest()) return $this->json([ "success" => 1 ]);
            return $this->redirectToRoute('app_mandat_coges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/mandat_coges/new.html.twig', [
            'mandat_coge' => $mandatCoge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mandat_coges_show', methods: ['GET'])]
    public function show(MandatCoges $mandatCoge): Response
    {
        return $this->render('backend/mandat_coges/show.html.twig', [
            'mandat_coge' => $mandatCoge,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mandat_coges_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MandatCoges $mandatCoge, MandatCogesRepository $mandatCogesRepository): Response
    {
        $form = $this->createForm(MandatCogesType::class, $mandatCoge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mandatCogesRepository->add($mandatCoge, true);
            if($request->isXmlHttpRequest()) return $this->json([ "success" => 1 ]);
            return $this->redirectToRoute('app_mandat_coges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/mandat_coges/edit.html.twig', [
            'mandat_coge' => $mandatCoge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mandat_coges_delete', methods: ['POST'])]
    public function delete(Request $request, MandatCoges $mandatCoge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mandatCoge->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mandatCoge);
            $entityManager->flush();
        }
        if($request->isXmlHttpRequest()) return $this->json([ "success" => 1 ]);
        return $this->redirectToRoute('app_mandat_coges_index', [], Response::HTTP_SEE_OTHER);
    }
}
