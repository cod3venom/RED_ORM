<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 07:12
*/

namespace unit\query_builder_tests;

require "../../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use src\query_builder\helpers\abstractions\Where;
use src\query_builder\QueryBuilder;

class TEST_DELETE_QUERY_BUILDER extends TestCase
{
    public function testUpdateQueryBuilder(){
        $expected = "delete from USER_PROFILE where EMAIL = ?";

        $generated =  QueryBuilder::Delete("USER_PROFILE")
            ->where("EMAIL")->equals()
            ->__toString();

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }

    public function testUpdateQueryBuilder_WITH_OR_OPERATOR(){
        $expected = "delete from USER_PROFILE where EMAIL = ? or ID > ?";

        $generated =  QueryBuilder::Delete("USER_PROFILE")
            ->where("EMAIL")->equals()->or()
            ->where("ID")->greaterThan()
            ->__toString();

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }

    public function testUpdateQueryBuilder_WITH_AND_OPERATOR(){
        $expected = "delete from USER_PROFILE where EMAIL = ? and ID > ?";

        $generated =  QueryBuilder::Delete("USER_PROFILE")
            ->where("EMAIL")->equals()->and()
            ->where("ID")->greaterThan()
            ->__toString();

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }
}