<?php

namespace App\Controller;


use App\Entity\Dren;
use App\Form\DrenType;
use App\Helper\DataTableHelper;
use App\Helper\FileUploadHelper;
use App\Repository\CommuneRepository;
use App\Repository\DrenRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/dren')]
class DrenController extends AbstractController
{
    #[Route('/import-file', name: 'app_dren_import', methods: ['GET'])]
    public function importFile(Request $request): Response
    {
        return $this->render('backend/dren/import.html.twig');
    }

    #[Route('/ajax/select2', name: 'app_dren_select2_ajax', methods: ['GET', 'POST'])]
    public function ajaxSelect2(Request $request, DrenRepository $drenRepository): JsonResponse
    {
        $drens = $drenRepository->findAllAjaxSelect2($request->get('search'));
        return $this->json([ "results" => $drens, "pagination" => ["more" => true]]);
    }

    #[Route('/ajax/upload', name: 'app_dren_upload_file_ajax', methods: ['POST'])]
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

    #[Route('/process/import-file', name: 'app_dren_proccess_file', methods: ['GET', 'POST'])]
    public function processUploadedFile(Request $request,
                                        DrenRepository $drenRepository): Response
    {
        /* @var UploadedFile $file */
        $file = $request->getSession()->get('user.uploadedfile');
        if($file){
            $fp = fopen($file,'r');
            $header = fgetcsv($fp,null,";");
            while($row = fgetcsv($fp,null,";")){
                $data = array_combine($header, $row);
                $dren = new Dren();
                if(isset($data['LIBELLE'])) $dren->setLibelle($data['LIBELLE']);
                if(isset($data['EMAIL'])) $dren->setEmail($data['EMAIL']);
                if(isset($data['TELEPHONE'])) $dren->setTelephone($data['TELEPHONE']);
                $drenRepository->add($dren);
            }
            $drenRepository->flush();
            if(file_exists($file)) unlink($file);
            $request->getSession()->set('user.uploadedfile', null);
            return $this->redirectToRoute('app_dren_index');
        }else{
            return $this->redirectToRoute('app_dren_index');
        }
    }

    #[Route('/ajax/new', name: 'app_dren_new_ajax', methods: ['GET', 'POST'])]
    public function newAjax(Request $request, EntityManagerInterface $entityManager): Response
    {
        if($request->isXmlHttpRequest()) {
            $data = array_filter($request->request->all(),function($d) {
                return !empty($d);
            });
            $connection = $entityManager->getConnection();
            $connection->insert('dren', $data);
            return $this->json('saved');
        }
        return $this->json('error');
    }

    #[Route('/datatable', name: 'app_dren_dt', methods: ['GET', 'POST'])]
    public function datatable(Request $request,
                              Connection $connection)
    {
        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'dren';
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
                'db' => 'email',
                'dt' => 'email',
            ],
            [
                'db' => 'telephone',
                'dt' => 'telephone',
            ],
            [
                'db' => 'id',
                'dt' => '',
                'formatter' => function($d, $row){
                    $dren_id = $row['id'];
                    $content = sprintf("<div class='d-flex'><span class='btn btn-primary shadow btn-xs sharp me-1' data-dren-id='%s'><i class='fa fa-pencil'></i></span><span data-dren-id='%s' class='btn btn-danger shadow btn-xs sharp'><i class='fa fa-trash'></i></span></div>", $dren_id, $dren_id);
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

        if(!empty($params['libelle_filter'])) {
            $whereResult .= " libelle = '". $params['region_filter'] . "' AND";
        }

        if($whereResult) $whereResult = substr_replace($whereResult,'',-strlen(' AND'));
        $response = DataTableHelper::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult);

        return new JsonResponse($response);
    }

    #[Route('/', name: 'app_dren_index', methods: ['GET','POST'])]
    public function index(Request $request,  DataTableFactory $dataTableFactory): Response
    {
        $table = $dataTableFactory->create()
                ->add('id', TextColumn::class,['label' => '#'])
                ->add('libelle', TextColumn::class,['label' => 'Libellé'])
                ->add('description', TextColumn::class, ['label' => 'Description'])
                ->add('actions', TextColumn::class, ['label' => '', 'orderable' => false,
                    'render' => function($value, $context) {
                        $commune_id = $context->getId();
                        return sprintf("<div class='d-flex'><span class='btn btn-primary shadow btn-xs sharp me-1' data-commune-id='%s'><i class='fa fa-pencil'></i></span><span data-commune-id='%s' class='btn btn-danger shadow btn-xs sharp'><i class='fa fa-trash'></i></span></div>", $commune_id, $commune_id);
                    }
                ])
                ->createAdapter(ORMAdapter::class, ['entity' => Dren::class])
                ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('backend/dren/index.html.twig', [ 'datatable' => $table ]);
    }

    #[Route('/new', name: 'app_dren_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dren = new Dren();
        $form = $this->createForm(DrenType::class, $dren);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dren);
            $entityManager->flush();
            return $this->redirectToRoute('app_dren_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/dren/new.html.twig',[ 'dren' => $dren, 'form' => $form ]);
    }

    #[Route('/{id}', name: 'app_dren_show', methods: ['GET'])]
    public function show(Dren $dren): Response
    {
        return $this->render('backend/dren/show.html.twig', ['dren' => $dren ]);
    }

    #[Route('/{id}/edit', name: 'app_dren_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dren $dren, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DrenType::class, $dren);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_dren_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/dren/edit.html.twig', [ 'dren' => $dren, 'form' => $form ]);
    }

    #[Route('/{id}', name: 'app_dren_delete', methods: ['POST'])]
    public function delete(Request $request, Dren $dren, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dren->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dren);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dren_index', [], Response::HTTP_SEE_OTHER);
    }

}
