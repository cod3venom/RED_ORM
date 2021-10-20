<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 08:33
*/

namespace src\query_builder\helpers;

use mysqli_stmt;
use src\database\drivers\mysql\MySqlDriver;
use src\query_builder\helpers\abstractions\Where;

abstract class AbstractResource extends MySqlDriver
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDriver(): MySqlDriver
    {
        return $this;
    }

    public function __Where(string $sql): Where
    {
        $whereObj = new Where();
        $whereObj->sql = $sql;
        return $whereObj;
    }
}