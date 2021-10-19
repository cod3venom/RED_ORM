<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 14:03
*/

namespace src\database\drivers;



abstract class AbstractDriver
{
    public function AdoptClass(string $className): array
    {
       return [];
    }
}