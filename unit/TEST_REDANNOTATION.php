<?php

/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 18.10.2021
 * Time: 20:24
*/

namespace unit;

require "../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use src\annotation\dto\ColumnAnnotationTObject;
use src\annotation\dto\TableAnnotationTObject;
use src\annotation\RedAnnotation;

class TEST_REDANNOTATION extends TestCase
{


    public function testAnnotationTableParser(){
        $annotation = "
        /** examples
        * user id
        * @Table(name=users);
        * @var int 
        */";

        $data = RedAnnotation::ParseAnnotation($annotation);
        $this->assertInstanceOf(TableAnnotationTObject::class, $data["object"]);

    }


    public function testAnnotationColumnParser(){
        $annotation = "
        /** examples
        * user id
        * @Column(name=id, type=int, nullable=false);
        * @var int 
        */";

        $data = RedAnnotation::ParseAnnotation($annotation);
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

        $data = RedAnnotation::ParseAnnotations($annotations);
        $this->assertEquals("users_profile", $data->tableAnnotationTObject->name);
    }
}