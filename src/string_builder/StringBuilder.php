<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 10:24
*/

namespace src\string_builder;

class StringBuilder
{
    private string $str = "";

    public function append(string $input): StringBuilder{
        $this->str .= $input;
        return $this;
    }

    public function __reset(): StringBuilder
    {
        $this->str = "";
        return $this;
    }

    public function __toString()
    {
        return $this->str;
    }
}