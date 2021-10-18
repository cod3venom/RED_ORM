<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 18.10.2021
 * Time: 19:43
*/

namespace src\annotation\dto;

class TableAnnotationTObject
{
    public string $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}