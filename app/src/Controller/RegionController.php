<?php

namespace App\Controller;

use App\Entity\Region;
use App\Form\RegionType;
use App\Helper\FileUploadHelper;
use App\Repository\MandatCogesRepository;
use App\Repository\RegionRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\BoolColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/admin/region')]
class RegionController extends AbstractController
{

    #[Route('/import-file', name: 'app_region_import', methods: [ 'GET'])]
    public function importFile(Request $request): Response
    {
        return $this->render('backend/region/import.html.twig');
    }


    #[Route('/ajax/select2', name: 'app_region_select2_ajax', methods: ['GET', 'POST'])]
    public function ajaxSelect2(Request $request, RegionRepository $regionRepository): JsonResponse
    {
        $regionRepository = $regionRepository->findAllAjaxSelect2($request->get('search'));
        return $this->json([ "results" => $regionRepository, "pagination" => ["more" => true]]);
    }

    #[Route('/ajax/upload', name: 'app_region_upload_file_ajax', methods: [ 'POST'])]
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

    #[Route('/process/import-file', name: 'app_region_proccess_file', methods: ['GET', 'POST'])]
    public function processUploadedFile(Request $request, RegionRepository $regionRepository): Response
    {
        /* @var UploadedFile $file */
        $file = $request->getSession()->get('user.uploadedfile');
        if($file){
            $fp = fopen($file,'r');
            $header = fgetcsv($fp,null,";");
            while($row = fgetcsv($fp,null,";")){
                $data = array_combine($header, $row);
                $region = new Region();
                $region->setLibelle($data['LIBELLE']);
                $regionRepository->add($region);
            }
            $regionRepository->flush();
            if(file_exists($file)) unlink($file);
            $request->getSession()->set('user.uploadedfile', null);
            return $this->redirectToRoute('app_region_index');
        }else{
            return $this->redirectToRoute('app_region_index');
        }
    }

    #[Route('/', name: 'app_region_index', methods: ['GET', 'POST'])]
    public function index(Request $request, DataTableFactory $dataTableFactory, RegionRepository $regionRepository): Response
    {
        $table = $dataTableFactory->create()
            ->add('id', TextColumn::class,['label' => '#'])
            ->add('libelle', TextColumn::class,['label' => 'Libellé'])
            ->add('description', TextColumn::class, ['label' => 'Description'])
            ->add('actions', TextColumn::class,
                [
                    'label' => '',
                    'orderable'=> false,
                    'render' => function($value, $context) {
                        $region_id = $context->getId();
                        return sprintf("<div class='d-flex'><span class='btn btn-primary shadow btn-xs sharp me-1' data-region-id='%s'><i class='fa fa-pencil'></i></span><span data-region-id='%s' class='btn btn-danger shadow btn-xs sharp'><i class='fa fa-trash'></i></span></div>", $region_id, $region_id);
                    }
                ]
            )
            ->createAdapter(ORMAdapter::class, [
                'entity' => Region::class
            ])
            ->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('backend/region/index.html.twig', [
            'datatable' => $table,
            'regions' => $regionRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_region_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $region = new Region();
        $form = $this->createForm(CogesType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($region);
            $entityManager->flush();

            return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/region/new.html.twig', [
            'region' => $region,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_region_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Region $region): Response
    {
        return $this->render('backend/region/show.html.twig', [
            'region' => $region,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_region_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Region $region, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CogesType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/region/edit.html.twig', [
            'region' => $region,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_region_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Region $region, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$region->getId(), $request->request->get('_token'))) {
            $entityManager->remove($region);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
    }

}
