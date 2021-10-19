<?php

/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 18.10.2021
 * Time: 20:24
*/

namespace unit\annotation_parser_test;

use PHPUnit\Framework\TestCase;
use src\annotation\dto\ColumnAnnotationTObject;
use src\annotation\dto\TableAnnotationTObject;
use src\annotation\Annotation;
use src\test_models\UserProfile;

class TEST_ANNOTATION_PARSER extends TestCase
{


    public function testAnnotationTableParser(){
        $annotation = "
        /** examples
        * user id
        * @Table(name=users);
        * @var int 
        */";

        $data = Annotation::ParseAnnotation($annotation);
        $this->assertInstanceOf(TableAnnotationTObject::class, $data["object"]);

    }


    public function testAnnotationColumnParser(){
        $annotation = "
        /** examples
        * user id
        * @Column(name=id, type=int, nullable=false);
        * @var int 
        */";

        $data = Annotation::ParseAnnotation($annotation);

        $expected = "src\annotation\dto\ColumnAnnotationTObject";
        $generated = get_class($data["object"]);

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;

        $this->assertEquals($expected,$generated);
        $this->assertInstanceOf(ColumnAnnotationTObject::class, $data["object"]);

    }

    public function testAnnotationToTablePack(){
        $annotations = [
            "
            /**
            * @Table(name=users_profile);
            * @var int 
            */",

            "
            /**
            * user id
            * @Column(name=user_id, type=int, nullable=false);
            * @var int 
            */",


            "
            /**
            * user id
            * @Column(name=user_email, type=string, nullable=false);
            * @var int 
            */",


            "
            /**
            * @Column(name=user_password, type=string, nullable=false);
            * @var int 
            */"
        ];

        $data = Annotation::ParseAnnotations($annotations);
        $expected = "users_profile";
        $generated = $data->tableAnnotationTObject->name;

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;

        $this->assertEquals($expected,$generated);
    }

    public function testRealClassModel(){
        $reflection = new \ReflectionClass(UserProfile::class);
        $comments = [$reflection->getDocComment()];
        foreach ($reflection->getProperties() as $property) {
            if (!($property instanceof \ReflectionProperty)) {
                continue;
            }
            $comments[] = $property->getDocComment();
        }

        $data = Annotation::ParseAnnotations($comments);

        $this->assertEquals("USER_PROFILE", $data->tableAnnotationTObject->name);
        $columns = array_map(
            function (ColumnAnnotationTObject $column) {
                return $column->name;
            }, $data->columnAnnotationObjects);

        $this->assertEquals(json_encode($columns), json_encode(["ID", "USER_EMAIL"]));
    }
}