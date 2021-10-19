<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 18.10.2021
 * Time: 19:30
*/

namespace src\annotation\helpers;


use src\annotation\dto\ColumnAnnotationTObject;
use src\annotation\dto\TableAnnotationTObject;
use src\annotation\flags\AnnotationTypes;



#######################################
#         Annotation Formats          #
#######################################
#   /** examples
#   * @Table(name=users)
#   */
#
#   /**
#   * Some description
#   * @Column(name=id, type=int, nullable=false)
#   */
#
class AnnotationsParser
{
    private string $regex = "/@table.*;|@Table.*;|@column.*;|@Column.*;/";

    private function splitOnComma(string $annotation): array{
        return explode(",", $annotation);
    }

    private function splitOnEquality(string $annotation): array{
        return explode("=", $annotation);
    }

    private function splitOnHashTag(string $annotation): array{
        return explode("#", $annotation);
    }

    private function parseValidAnnotations(string $annotation): string {

        $matches = [];
        preg_match($this->regex, $annotation, $matches);
        if (count($matches) === 0 ) {
            $annotation = "";
        } else {
            $annotation = (string)$matches[0];
        }
        $annotation = str_replace("/", "", $annotation);
        $annotation = str_replace("*", "", $annotation);
        $annotation = str_replace("(", "#", $annotation);
        $annotation = str_replace(");", "", $annotation);
        return str_replace("\n", "", $annotation);
    }

    private function scanAnnotationSegments(string $annotation): array
    {
        $splitOnHashTag = $this->splitOnHashTag($annotation);
        if (count($splitOnHashTag) < 2){
            return ["header"=>"", "body"=>[]];
        }
        $annotationType = trim((string)$splitOnHashTag[0]);
        $annotationBody = (string)$splitOnHashTag[1];
        return ["header"=>$annotationType, "body"=>$annotationBody];
    }

    private function tableAnnotationTObj(string $header, string $body): TableAnnotationTObject {
        $splitOnEquality = $this->splitOnEquality($body);
        if (count($splitOnEquality) < 2) {
            return new TableAnnotationTObject("");
        }

        if ((string)$splitOnEquality[0] !== "name"){
            return new TableAnnotationTObject("");
        }
        return new TableAnnotationTObject((string)$splitOnEquality[1]);
    }

    private function columnAnnotationTObj(string $header, string $body): ColumnAnnotationTObject {
        $splitOnCommas = $this->splitOnComma($body);
        $parameters = [];
        if (count($splitOnCommas) === 0) {
            return new ColumnAnnotationTObject([]);
        }

        foreach ($splitOnCommas as $paramItem){
            $onEquality = $this->splitOnEquality($paramItem);
            if (count($onEquality) < 2) {
                continue;
            }
            $key = preg_replace('/\s+/', '', (string)$onEquality[0]);
            $value = preg_replace('/\s+/', '', (string)$onEquality[1]);
            $parameters[$key] = $value;
        }
        return new ColumnAnnotationTObject($parameters);
    }

    public function Parse(string $annotation): array {
        $validAnnotation = $this->parseValidAnnotations($annotation);
        $scanned = $this->scanAnnotationSegments($validAnnotation);

        $header = strtolower((string)$scanned["header"]);
        $body = (string)$scanned["body"];

        (object) $obj = null;
        if ($header === AnnotationTypes::TABLE) {
            $obj = $this->tableAnnotationTObj($header, $body);
        } else if ($header === AnnotationTypes::COLUMN) {
            $obj = $this->columnAnnotationTObj($header, $body);
        }

        return ["type"=> $header, "object"=> $obj];
    }
}