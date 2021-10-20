<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 18.10.2021
 * Time: 19:27
*/

namespace src\annotation;

use src\annotation\dto\ColumnAnnotationTObject;
use src\annotation\dto\TableAnnotationTObject;
use src\annotation\dto\TablePackageAnnotationTObject;
use src\annotation\helpers\AnnotationsParser;
use src\annotation\helpers\ReflectionParser;

class Annotation
{
    /** examples
     * @table(name=users)
     * @column(name=id, type=int, nullable=false)
     */


    public static function ParseAnnotation(string $annotation): array
    {
        return (new AnnotationsParser())->parse($annotation);
    }

    public static function ParseAnnotations(array $annotationsPack): TablePackageAnnotationTObject
    {
        $parsedObjects = [];
        $table = null;
        $columnObjs = [];
        foreach ($annotationsPack as $annotation){
            $parsedObjects[] = self::ParseAnnotation($annotation);
        }

        foreach ($parsedObjects as $object){
            if (!isset($object["object"])){
                continue;
            }

            if ($object["object"] instanceof ColumnAnnotationTObject) {
                $columnObjs[] = $object["object"];
            }
            if ($object["object"] instanceof TableAnnotationTObject) {
                $table = $object["object"];
            }
        }
        return new TablePackageAnnotationTObject($table, $columnObjs);
    }

    public static function ParseClass(string $className): TablePackageAnnotationTObject
    {
        $reflectionParser = new ReflectionParser($className);
        return self::ParseAnnotations($reflectionParser->getAllDocs());
    }

}