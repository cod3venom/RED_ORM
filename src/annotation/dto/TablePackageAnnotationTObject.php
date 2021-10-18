<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 18.10.2021
 * Time: 19:48
*/

namespace src\annotation\dto;

class TablePackageAnnotationTObject
{
    public TableAnnotationTObject $tableAnnotationTObject;
    public array $columnAnnotationObjects = [];

    public function __construct(TableAnnotationTObject $tableAnnotationTObject, array $columnAnnotationTObject)
    {
        $this->tableAnnotationTObject = $tableAnnotationTObject;
        $this->castTypes($columnAnnotationTObject);
    }

    private function castTypes(array $columnAnnotationTObject){
        foreach ($columnAnnotationTObject as $columnAnnotation){
            if (!($columnAnnotation instanceof ColumnAnnotationTObject)){
                continue;
            }

            array_push($this->columnAnnotationObjects, $columnAnnotation);
        }
    }
}