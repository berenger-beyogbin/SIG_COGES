<?php

namespace App\Controller;


use App\Service\DbMetadataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/admin')]
class PageController extends AbstractController
{
    const TMPL_INDEX = "backend/pages/index.html.twig";
    const TMPL_DASHBOARD = "backend/pages/index.html.twig";
    const TMPL_DATA_ENTRY = "backend/pages/data_entry.html.twig";

    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render(self::TMPL_INDEX);
    }
    #[Route('/dashboard', name: 'app_dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }

    #[Route('/daps_coges', name: 'app_daps_coges', methods: ['GET'])]
    public function dapsCoges(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }

    #[Route('/creation_pacc', name: 'app_creation_pacc', methods: ['GET'])]
    public function creationPacc(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/execution_pacc', name: 'app_execution_pacc', methods: ['GET'])]
    public function executionPacc(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/paiement_fournisseurs', name: 'app_paiement_fournisseurs', methods: ['GET'])]
    public function paiementFournisseurs(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/mandats', name: 'app_mandats', methods: ['GET'])]
    public function mandats(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/membres', name: 'app_membres', methods: ['GET'])]
    public function membres(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/affectations_ecoles', name: 'app_affectations_ecoles', methods: ['GET'])]
    public function affectationsEcoles(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }

    #[Route('/data_entry', name: 'app_admin_data_entry', methods: ['GET'])]
    public function dataEntry(Request $request): Response
    {
        return $this->render(self::TMPL_DATA_ENTRY);
    }


    #[Route('/dbschema', name: 'app_dbschema', methods: ['GET'])]
    public function dbSchema(DbMetadataService $tableSchemaService): Response
    {
        $tableSchemaService->getDbMetadata();
        return $this->render(self::TMPL_DASHBOARD);
    }


}
