<?php
namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait AjaxDataEntry{

    #[Route('/app_region_partials_ajax', name: 'app_region_partials_ajax', methods: ['GET', 'POST'])]
    public function app_region_partials_ajax(Request $request): JsonResponse
    {
        $data = "<h4 class='mb-4'>REGION</h4><p>Velit aute mollit ipsum ad dolor consectetur nulla officia culpa adipisicing exercitation fugiat tempor. Voluptate deserunt sit sunt nisi aliqua fugiat proident ea ut. Mollit voluptate reprehenderit occaecat nisi ad non minim tempor sunt voluptate consectetur exercitation id ut nulla. Ea et fugiat aliquip nostrud sunt incididunt consectetur culpa aliquip eiusmod dolor. Anim ad Lorem aliqua in cupidatat nisi enim eu nostrud do aliquip veniam minim.</p>";
        return $this->json($data);
    }
    #[Route('/app_commune_partials_ajax', name: 'app_commune_partials_ajax', methods: ['GET', 'POST'])]
    public function app_commune_partials_ajax(Request $request): JsonResponse
    {
        $data = "<h4 class='mb-4'>REGION</h4><p>Velit aute mollit ipsum ad dolor consectetur nulla officia culpa adipisicing exercitation fugiat tempor. Voluptate deserunt sit sunt nisi aliqua fugiat proident ea ut. Mollit voluptate reprehenderit occaecat nisi ad non minim tempor sunt voluptate consectetur exercitation id ut nulla. Ea et fugiat aliquip nostrud sunt incididunt consectetur culpa aliquip eiusmod dolor. Anim ad Lorem aliqua in cupidatat nisi enim eu nostrud do aliquip veniam minim.</p>";
        return $this->json($data);
    }
    #[Route('/app_coges_partials_ajax', name: 'app_coges_partials_ajax', methods: ['GET', 'POST'])]
    public function app_coges_partials_ajax(Request $request): JsonResponse
    {
        $data = "<h4 class='mb-4'>REGION</h4><p>Velit aute mollit ipsum ad dolor consectetur nulla officia culpa adipisicing exercitation fugiat tempor. Voluptate deserunt sit sunt nisi aliqua fugiat proident ea ut. Mollit voluptate reprehenderit occaecat nisi ad non minim tempor sunt voluptate consectetur exercitation id ut nulla. Ea et fugiat aliquip nostrud sunt incididunt consectetur culpa aliquip eiusmod dolor. Anim ad Lorem aliqua in cupidatat nisi enim eu nostrud do aliquip veniam minim.</p>";
        return $this->json($data);
    }
    #[Route('/app_dren_partials_ajax', name: 'app_dren_partials_ajax', methods: ['GET', 'POST'])]
    public function app_dren_partials_ajax(Request $request): JsonResponse
    {
        $data = "<h4 class='mb-4'>REGION</h4><p>Velit aute mollit ipsum ad dolor consectetur nulla officia culpa adipisicing exercitation fugiat tempor. Voluptate deserunt sit sunt nisi aliqua fugiat proident ea ut. Mollit voluptate reprehenderit occaecat nisi ad non minim tempor sunt voluptate consectetur exercitation id ut nulla. Ea et fugiat aliquip nostrud sunt incididunt consectetur culpa aliquip eiusmod dolor. Anim ad Lorem aliqua in cupidatat nisi enim eu nostrud do aliquip veniam minim.</p>";
        return $this->json($data);
    }
    #[Route('/app_iepp_partials_ajax', name: 'app_iepp_partials_ajax', methods: ['GET', 'POST'])]
    public function app_iepp_partials_ajax(Request $request): JsonResponse
    {
        $data = "<h4 class='mb-4'>REGION</h4><p>Velit aute mollit ipsum ad dolor consectetur nulla officia culpa adipisicing exercitation fugiat tempor. Voluptate deserunt sit sunt nisi aliqua fugiat proident ea ut. Mollit voluptate reprehenderit occaecat nisi ad non minim tempor sunt voluptate consectetur exercitation id ut nulla. Ea et fugiat aliquip nostrud sunt incididunt consectetur culpa aliquip eiusmod dolor. Anim ad Lorem aliqua in cupidatat nisi enim eu nostrud do aliquip veniam minim.</p>";
        return $this->json($data);
    }
    #[Route('/app_etablissement_partials_ajax', name: 'app_etablissement_partials_ajax', methods: ['GET', 'POST'])]
    public function app_etablissement_partials_ajax(Request $request): JsonResponse
    {
        $data = "<h4 class='mb-4'>REGION</h4><p>Velit aute mollit ipsum ad dolor consectetur nulla officia culpa adipisicing exercitation fugiat tempor. Voluptate deserunt sit sunt nisi aliqua fugiat proident ea ut. Mollit voluptate reprehenderit occaecat nisi ad non minim tempor sunt voluptate consectetur exercitation id ut nulla. Ea et fugiat aliquip nostrud sunt incididunt consectetur culpa aliquip eiusmod dolor. Anim ad Lorem aliqua in cupidatat nisi enim eu nostrud do aliquip veniam minim.</p>";
        return $this->json($data);
    }
    #[Route('/app_fournisseur_partials_ajax', name: 'app_fournisseur_partials_ajax', methods: ['GET', 'POST'])]
    public function app_fournisseur_partials_ajax(Request $request): JsonResponse
    {
        $data = "<h4 class='mb-4'>REGION</h4><p>Velit aute mollit ipsum ad dolor consectetur nulla officia culpa adipisicing exercitation fugiat tempor. Voluptate deserunt sit sunt nisi aliqua fugiat proident ea ut. Mollit voluptate reprehenderit occaecat nisi ad non minim tempor sunt voluptate consectetur exercitation id ut nulla. Ea et fugiat aliquip nostrud sunt incididunt consectetur culpa aliquip eiusmod dolor. Anim ad Lorem aliqua in cupidatat nisi enim eu nostrud do aliquip veniam minim.</p>";
        return $this->json($data);
    }

    #[Route('/app_organe_partials_ajax', name: 'app_organe_partials_ajax', methods: ['GET', 'POST'])]
    public function app_organe_partials_ajax(Request $request): JsonResponse
    {
        $data = "<h4 class='mb-4'>REGION</h4><p>Velit aute mollit ipsum ad dolor consectetur nulla officia culpa adipisicing exercitation fugiat tempor. Voluptate deserunt sit sunt nisi aliqua fugiat proident ea ut. Mollit voluptate reprehenderit occaecat nisi ad non minim tempor sunt voluptate consectetur exercitation id ut nulla. Ea et fugiat aliquip nostrud sunt incididunt consectetur culpa aliquip eiusmod dolor. Anim ad Lorem aliqua in cupidatat nisi enim eu nostrud do aliquip veniam minim.</p>";
        return $this->json($data);
    }
}
