<?php
namespace App\Traits;


trait ImportTrait {

    function getRegionCsvColumns(): array
    {
        $columns = [
            "LIBELLE",
            "DESCRIPTION"
        ];
        return $columns ;
    }
    function getCommunesCsvColumns(): array
    {
        $columns = [
            "LIBELLE",
            "DESCRIPTION",
            "REGION"
        ];
        return $columns ;
    }

    function getIeppCsvColumns(): array
    {
        $columns = [
            "LIBELLE",
            "DREN",
            "EMAIL",
            "TELEPHONE"
        ];
        return $columns ;
    }

    function getEtablissementCsvColumns(): array
    {
        $columns = [
            "NOM",
            "LOCALITE",
            "TYPE_MILIEU",
            "CYCLE",
            "CODE ETABLISSEMENT",
            "IEPP",
            "DREN",
            "COGES"
        ];
        return $columns ;
    }

    function getOrganeCsvColumns(): array
    {
        $columns = [
            "LIBELLE",
        ];
        return $columns ;
    }


    function getCogesCsvColumns(): array
    {
        $columns = [
               "LIBELLE",
               "CYCLE",
               "N° COMPTE",
               "DOMICILIATION",
               "GROUPE SCOLAIRE",
               "IEPP",
               "COMMUNE",
               "DREN",
               "REGION",
               "COMMUNE",
           ];
           return $columns ;
    }

    function getDrenCsvColumns(): array
    {
        $columns = [
            "LIBELLE",
            "DREN",
            "EMAIL",
            "TELEPHONE"
        ];
        return $columns ;
    }

    function getPosteCsvColumns(): array
    {
        $columns = [
            "LIBELLE",
            "ORGANE"
        ];
        return $columns ;
    }

    function getSourceCsvColumns(): array
    {
        $columns = [
            "LIBELLE",
        ];
        return $columns ;
    }
}
