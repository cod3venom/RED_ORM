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

class TEST_SELECT_QUERY_BUILDER extends TestCase
{
    public function testSelectCustom(){
        $expected = "select EMAIL, PASSWORD from USER_PROFILES";
        $generated =  QueryBuilder::Select(["EMAIL", "PASSWORD"])->from("USER_PROFILES")->__toString();;

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }

    public function testSelectAll(){
        $expected = "select * from USER_PROFILES";
        $generated =  QueryBuilder::Select([])->from("USER_PROFILES")->__toString();;

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }

    public function testGenerateWhereClause_SINGLE_OPERATOR(){
        $expected = "ID > ?";
        $generated = (new Where())
            ->where("ID")->greaterThan()->__toString();
        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }

    public function testGenerateWhereClause_AND_OPERATOR(){
        $expected = "ID > ? and USER_NAME != ?";
        $generated = (new Where())
            ->where("ID")->greaterThan()->and()
            ->where("USER_NAME")->notEquals()->__toString();

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }

    public function testGenerateWhereClause_OR_OPERATOR(){
        $expected = "ID > ? or ID < ?";
        $generated = (new Where())
            ->where("ID")->greaterThan()->or()
            ->where("ID")->lessThan()->__toString();

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }

    public function testSelect_With_Multiple_WHERE_AND_OPERATORS(){
        $expected = "select EMAIL, PASSWORD from USER_PROFILES where ID > ? and EMAIL != ?";
        $generated =  QueryBuilder::Select(["EMAIL", "PASSWORD"])->from("USER_PROFILES")
            ->where("ID")->greaterThan()->and()
            ->where("EMAIL")->notEquals()->__toString();

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }

    public function testSelect_With_Multiple_WHERE_OR_OPERATORS(){
        $expected = "select EMAIL, PASSWORD from USER_PROFILES where ID > ? or EMAIL != ? and USERNAME = ?";

        $generated =  QueryBuilder::Select(["EMAIL", "PASSWORD"])->from("USER_PROFILES")
            ->where("ID")->greaterThan()->or()
            ->where("EMAIL")->notEquals()->and()
            ->where("USERNAME")->equals()->__toString();

        echo PHP_EOL."expected :".$expected;
        echo PHP_EOL."generated :".$generated;
        $this->assertEquals($expected, $generated);
    }
}