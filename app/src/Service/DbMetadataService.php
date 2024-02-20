<?php


namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

class DbMetadataService
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getDbMetadata()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $schemaManager = $em->getConnection()->createSchemaManager();
        $namespaces = $em->getConfiguration()->getEntityNamespaces();

        $tables = $schemaManager->listTables();

        $metadata = [];
        foreach ($tables as $table) {
            foreach ($table->getColumns() as $column) {
                $metadata[($table->getName())][] = [
                    "column" => $column->getName(),
                    "type" => $column->getType()->getName(),
                ];
            }
        }

        return $metadata;
    }


}//end class
