<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 07:12
*/

namespace unit\query_builder_tests;

require "../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use src\query_builder\helpers\abstractions\Where;
use src\query_builder\QueryBuilder;

class TEST_INSERT_QUERY_BUILDER extends TestCase
{
    public function testUpdateQueryBuilder(){
        $expected = "insert into USER_PROFILE (ID, EMAIL) values (?, ?)";

        $generated =  QueryBuilder::Insert(["ID", "EMAIL"])
            ->into("USER_PROFILE")
            ->__toString();

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }

}