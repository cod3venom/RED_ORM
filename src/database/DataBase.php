<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 13:24
*/

namespace src\database;

use src\database\drivers\mysql\MySqlDriver;
use src\database\interfaces\IDataBase;

class DataBase implements IDataBase
{

    public static function Connect(): MySqlDriver
    {
       return (new MySqlDriver())->connect();
    }

    public static function Disconnect()
    {
        // TODO: Implement Disconnect() method.
    }
}