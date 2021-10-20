<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 09:59
*/

namespace src\query_builder\helpers;

use src\query_builder\helpers\abstractions\Where;
use src\string_builder\StringBuilder;

class Delete extends AbstractResource
{
    public string $sql = "";
    private string $table = "";
    private StringBuilder $stb;

    public function __construct(string $table)
    {
        parent::__construct();
        $this->table = $table;
        $this->stb = new StringBuilder();
    }

    public function where(string $whereColumn): Where{
        $this->__toString();
        $this->sql .= " where ";
        return $this->__Where($this->sql)->where($whereColumn);
    }

    /**
     * Compile query
     * @return string
     */
    public function __toString()
    {
        if (empty($this->table)) {
            throw new \InvalidArgumentException("[UPDATE_GEN] table name can't be empty");
        }

        $this->sql = $this->stb->append("delete from ")->append($this->table)->__toString();
        return $this->sql;
    }
}