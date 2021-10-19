<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 07:29
*/

namespace src\query_builder\helpers;

use src\query_builder\helpers\abstractions\Where;
use src\string_builder\StringBuilder;

class Update extends AbstractResource
{
    public string $sql = "";
    private string $table = "";
    private array $columns = [];
    private StringBuilder $stb;


    public function __construct(string $table)
    {
        $this->table = $table;
        $this->stb = new StringBuilder();
    }

    public function set(array $columns): Update
    {
        $this->columns = $columns;
        return $this;
    }

    public function where(string $whereColumn): Where{
        $this->__toString();
        $this->sql .= " where ";
        return $this->__Where($this->sql)->where($whereColumn);
    }

    public function __toString()
    {
        if (empty($this->table)){
            throw new \InvalidArgumentException("[UPDATE_GEN] table name can't be empty");
        }
        if (count($this->columns) === 0) {
            throw new \InvalidArgumentException("[UPDATE_GEN] columns can't be empty");
        }

        $this->sql = $this->stb->append("update")->__toString();
        (string)$columns = implode(",", array_map( function ($column) { return sprintf(" %s = ?",$column);}, $this->columns));

        $this->sql = $this->stb
            ->append(" ")
            ->append($this->table)
            ->append(" ");

        $this->sql = $this->stb
            ->append("set")
            ->append($columns);
        return $this->sql;
    }

}