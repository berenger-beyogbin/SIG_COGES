<?php

namespace App\Service\Gratification;

use App\Entity\Gratification;
use App\Helper\CsvReaderHelper;
use App\Helper\FileUploadHelper;
use App\Repository\GratificationRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 *
 */
class GratificationService
{

    public function __construct(
        private FileUploadHelper              $fileUploadHelper,
        private GratificationRepository $gratificationRepository,
        private CsvReaderHelper                $csvReaderHelper)
    {
    }

    public function processFile($annee, $mois, $file)
    {
        try {
            $filename = $this->fileUploadHelper->upload(
                new File($file),
                "/var/www/html/public/gratification"
            );
            if($filename){

                $context = [
                    CsvEncoder::DELIMITER_KEY => ';',
                    CsvEncoder::ENCLOSURE_KEY => '"',
                    CsvEncoder::ESCAPE_CHAR_KEY => '\\',
                    CsvEncoder::KEY_SEPARATOR_KEY => ';',
                ];
                $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
                $rows = $serializer->decode(file_get_contents($filename->getRealPath()), 'csv', $context);
                foreach($rows as $row){
                    $gratification = $this->gratificationRepository->findOneBy(['matricule' => trim($row['matricule'])]);
                    if(!$gratification) {
                        $gratification = new Gratification();
                        $gratification->setMatricule(strtoupper(trim($row['matricule'])));
                        $gratification->setFonction(strtoupper(trim($row['fonction'])));
                        $gratification->setFullname(strtoupper(trim($row['nom complet'])));
                    }
                    switch($mois){
                        case "Janvier":
                            $gratification->setJanvier($row['gratification']);
                             break;
                        case "Février":
                            $gratification->setFevrier($row['gratification']);
                            break;
                        case "Mars":
                            $gratification->setMars($row['gratification']);
                            break;
                        case "Avril":
                            $gratification->setAvril($row['gratification']);
                            break;
                        case "Mai":
                            $gratification->setMai($row['gratification']);
                            break;
                        case "Juin":
                            $gratification->setJuin($row['gratification']);
                            break;
                        case "Juillet":
                            $gratification->setJuillet($row['gratification']);
                            break;
                        case "Aôut":
                            $gratification->setAout($row['gratification']);
                            break;
                        case "Septembre":
                            $gratification->setSeptembre($row['gratification']);
                            break;
                        case "Octobre":
                            $gratification->setOctobre($row['gratification']);
                            break;
                        case "Novembre":
                            $gratification->setNovembre($row['gratification']);
                            break;
                        case "Décembre":
                            $gratification->setDecembre($row['gratification']);
                            break;
                    }
                    $this->gratificationRepository
                        ->save($gratification, true);
                }

                \unlink($filename->getRealPath());
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}

