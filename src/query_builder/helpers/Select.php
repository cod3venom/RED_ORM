<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 06:40
*/

namespace src\query_builder\helpers;

use \InvalidArgumentException;
use src\query_builder\helpers\abstractions\Where;
use src\string_builder\StringBuilder;

class Select extends AbstractResource
{
    public string $sql = "";
    private string $selectionArea = " *";
    private array $columns = [];
    private string $table = "";
    private StringBuilder $stb;

    public function __construct(array $columns) {
        $this->columns = $columns;
        $this->stb = new StringBuilder();
    }

    public function from(string $table): Select
    {
        $this->table = $table;
        return $this;
    }

    public function where(string $whereColumn): Where{
        $this->__toString();
        $this->sql .= " where ";
        return $this->__Where($this->sql)->where($whereColumn);
    }

    public function __toString()
    {
        if (empty($this->table)) {
            throw new \InvalidArgumentException("table property can't be empty");
        }
        if (count($this->columns) > 0) {
            $this->selectionArea = implode(",", array_map(function ($column) { return " ".$column; }, $this->columns ));
        }

        $this->sql = $this->stb
            ->append("select")
            ->__toString();

        $this->sql = $this->stb
            ->append($this->selectionArea);

        $this->sql = $this->stb
            ->append(" from ")
            ->append($this->table);

        return $this->sql;
    }

}