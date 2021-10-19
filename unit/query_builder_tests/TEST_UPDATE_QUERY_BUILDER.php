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

class TEST_UPDATE_QUERY_BUILDER extends TestCase
{
    public function testUpdateQueryBuilder(){
        $expected = "update USER_PROFILE set ID = ?, EMAIL = ?";

        $generated =  QueryBuilder::Update("USER_PROFILE")
                ->set(["ID", "EMAIL"])->__toString();

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }
    public function testUpdateQueryBuilder_with_where_clause_and_OR_OPERATOR () {
        $expected = "update USER_PROFILE set ID = ?, EMAIL = ? where ID > ? or EMAIL != ?";

        $generated =  QueryBuilder::Update("USER_PROFILE")
            ->set(["ID", "EMAIL"])
            ->where("ID")->greaterThan()->or()
            ->where("EMAIL")->notEquals()->__toString();

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }

    public function testUpdateQueryBuilder_with_where_clause_and_AND_OPERATOR () {
        $expected = "update USER_PROFILE set ID = ?, EMAIL = ? where ID > ? and EMAIL != ?";

        $generated =  QueryBuilder::Update("USER_PROFILE")
            ->set(["ID", "EMAIL"])
            ->where("ID")->greaterThan()->and()
            ->where("EMAIL")->notEquals()->__toString();

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }
}