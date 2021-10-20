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
use src\database\DataBase;
use src\query_builder\helpers\abstractions\Where;
use src\query_builder\QueryBuilder;
use src\RedORM;
use src\test_models\UserProfile;

class TEST_DATABASE extends TestCase
{
    public function testUpdateQueryBuilder(){
       $data = RedORM::Connect()->adoptClass(UserProfile::class);
    }


}