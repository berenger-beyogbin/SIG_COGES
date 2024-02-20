<?php

namespace App\Controller;

use App\Entity\Coges;
use App\Entity\Commune;
use App\Entity\Iepp;
use App\Entity\Region;
use App\Form\IeppType;
use App\Helper\FileUploadHelper;
use App\Repository\CommuneRepository;
use App\Repository\DrenRepository;
use App\Repository\IeppRepository;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/iepp')]
class IeppController extends AbstractController
{
    #[Route('/import-file', name: 'app_iepp_import', methods: [ 'GET'])]
    public function importFile(Request $request): Response
    {
        return $this->render('backend/iepp/import.html.twig');
    }

    #[Route('/ajax/select2', name: 'app_iepp_select2_ajax', methods: ['GET', 'POST'])]
    public function ajaxSelect2(Request $request, IeppRepository $ieppRepository): JsonResponse
    {
        $iepps = $ieppRepository->findAllAjaxSelect2($request->get('search'));
        return $this->json([ "results" => $iepps, "pagination" => ["more" => true]]);
    }

    #[Route('/ajax/upload', name: 'app_iepp_upload_file_ajax', methods: ['POST'])]
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

    #[Route('/process/import-file', name: 'app_iepp_proccess_file', methods: ['GET', 'POST'])]
    public function processUploadedFile(Request $request,
                                        DrenRepository $drenRepository,
                                        IeppRepository $ieppRepository,
                                        ): Response
    {
        /* @var UploadedFile $file */
        $file = $request->getSession()->get('user.uploadedfile');
        if($file){
            $fp = fopen($file,'r');
            $header = fgetcsv($fp,null,";");
            while($row = fgetcsv($fp,null,";")){
                $data = array_combine($header, $row);
                $iepp = new Iepp();
                if(isset($data['LIBELLE'])) $iepp->setLibelle($data['LIBELLE']);
                if(isset($data['EMAIL'])) $iepp->setEmail($data['EMAIL']);
                if(isset($data['TELEPHONE']))  $iepp->setTelephone($data['TELEPHONE']);
                if(isset($data['DREN'])) {
                    $dren = $drenRepository->findOneBy(['libelle' => $data['DREN']]);
                    if($dren) $iepp->setDren($dren);
                }
                $ieppRepository->add($iepp);
            }
            $ieppRepository->flush();
            if(file_exists($file)) unlink($file);
            $request->getSession()->set('user.uploadedfile', null);
            return $this->redirectToRoute('app_iepp_index');
        }else{
            return $this->redirectToRoute('app_iepp_index');
        }
    }

    #[Route('/ajax/new', name: 'app_iepp_new_ajax', methods: ['GET', 'POST'])]
    public function newAjax(Request $request, EntityManagerInterface $entityManager): Response
    {
        if($request->isXmlHttpRequest()) {
            $data = array_filter($request->request->all(),function($d) {
                return !empty($d);
            });
            $connection = $entityManager->getConnection();
            $connection->insert('iepp', $data);
            return $this->json('saved');
        }
        return $this->json('error');
    }


    #[Route('/', name: 'app_iepp_index', methods: ['GET', 'POST'])]
    public function index(Request $request,  DataTableFactory $dataTableFactory, DrenRepository $drenRepository): Response
    {
        $table = $dataTableFactory->create()
            ->add('id', TextColumn::class,['label' => '#'])
            ->add('libelle', TextColumn::class,['label' => 'Libellé'])
            ->add('email', TextColumn::class, ['label' => 'Email'])
            ->add('telephone', TextColumn::class, ['label' => 'Téléphone'])
            ->add('dren', TextColumn::class, ['field' => 'dren.libelle', 'label' => 'Dren','render' => function($value, $context) {
                return sprintf("<a href='/admin/dren/%s' class='link-info'>%s</a>",  $context->getDren()?->getId(), $value);
            }])
            ->add('actions', TextColumn::class,
                [
                    'label' => '',
                    'orderable'=> false,
                    'render' => function($value, $context) {
                        $iepp_id = $context->getId();
                        return sprintf("<div class='d-flex'><span class='btn btn-primary shadow btn-xs sharp me-1' data-iepp-id='%s'><i class='fa fa-pencil'></i></span><span data-iepp-id='%s' class='btn btn-danger shadow btn-xs sharp'><i class='fa fa-trash'></i></span></div>", $iepp_id, $iepp_id);
                    }
                ]
            )
            ->createAdapter(ORMAdapter::class, [
                'entity' => Iepp::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('iepp')
                        ->from(Iepp::class, 'iepp')
                        ->leftJoin('iepp.dren', 'dren')
                    ;
                },
            ])
            ->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('backend/iepp/index.html.twig', [
            'datatable' => $table,
            'drens' => $drenRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_iepp_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $iepp = new Iepp();
        $form = $this->createForm(IeppType::class, $iepp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($iepp);
            $entityManager->flush();

            return $this->redirectToRoute('app_iepp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/iepp/new.html.twig', [
            'iepp' => $iepp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_iepp_show', methods: ['GET'])]
    public function show(Iepp $iepp): Response
    {
        return $this->render('backend/iepp/show.html.twig', [
            'iepp' => $iepp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_iepp_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Iepp $iepp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IeppType::class, $iepp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_iepp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/iepp/edit.html.twig', [
            'iepp' => $iepp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_iepp_delete', methods: ['POST'])]
    public function delete(Request $request, Iepp $iepp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$iepp->getId(), $request->request->get('_token'))) {
            $entityManager->remove($iepp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_iepp_index', [], Response::HTTP_SEE_OTHER);
    }
}
