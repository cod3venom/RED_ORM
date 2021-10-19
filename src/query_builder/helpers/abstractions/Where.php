<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 07:44
*/

namespace src\query_builder\helpers\abstractions;

class Where
{
    public string $sql = "";
    private string $whereColumn = "";
    private string $whereOperator = "";

    public function where($whereColumn): self
    {
        $this->whereColumn = $whereColumn;
        return $this;
    }

    public function equals(): Where
    {
        $this->whereOperator = "=";
        return $this;
    }

    public function notEquals(): Where
    {
        $this->whereOperator = "!=";
        return $this;
    }

    public function greaterThan(): Where
    {
        $this->whereOperator = ">";
        return $this;
    }

    public function lessThan(): Where
    {
        $this->whereOperator = "<";
        return $this;
    }

    public function and(): Where {
        $this->__toString();
        $newObj = new Where();
        $newObj->sql = $this->sql . " and ";
        return $newObj;
    }

    public function or(): Where {
        $this->__toString();
        $newObj = new Where();
        $newObj->sql = $this->sql . " or ";
        return $newObj;
    }

    public function __toString(){
        $this->sql .= !empty($this->whereColumn) ? sprintf("%s %s ?", $this->whereColumn, $this->whereOperator) : "";
        return $this->sql;
    }
}