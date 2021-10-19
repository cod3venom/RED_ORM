<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 13:25
*/

namespace src\database\interfaces;

interface IDataBase
{
    public static function Connect();
    public static function Disconnect();
}