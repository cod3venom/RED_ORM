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
use src\class_parser\annotations\Reflectors;
use src\test_models\UserProfile;

class TEST_CLASS_PARSER extends TestCase
{
    public function testUpdateQueryBuilder(){
        $reflection = new Reflectors(UserProfile::class);
        $reflectionB = new Reflectors((new UserProfile()));

        #var_dump($reflection->getPropertiesWithComments());
        var_dump($reflectionB->getPropertiesWithComments());;

    }

}