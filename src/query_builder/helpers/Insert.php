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

class Insert extends AbstractResource
{
    /**
     * Final query
     * @var string
     */
    public string $sql = "";

    /**
     * Columns list
     * @var array
     */
    private array $columns = [];

    /**
     * Database table
     * @var string
     */
    private string $table = "";

    /**
     * @var StringBuilder
     */
    private StringBuilder $stb;

    /**
     * @param array $columns
     */
    public function __construct(array $columns) {
        $this->columns = $columns;
        $this->stb = new StringBuilder();
    }

    /**
     * Set table name
     * @param string $table
     * @return $this
     */
    public function into(string $table): Insert
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Compile query
     * @return string
     */
    public function __toString()
    {
        if (empty($this->table)) {
            throw new \InvalidArgumentException("table property can't be empty");
        }
        if (count($this->columns) === 0){
            throw new \InvalidArgumentException("[INSERT_GEN] inserting columns property can't be empty");
        }

        (string)$columns =  implode(",", array_map(function ($column) { return sprintf("%s", $column);}, $this->columns ));
        (string)$placeHolders = implode(",", array_map(function ($column) { return "?"; }, $this->columns ));

        $this->sql = $this->stb->append("insert into ")
            ->append($this->table)
            ->append(" ")
            ->__toString();

        $this->sql = $this->stb->append("(")
            ->append($columns)
            ->append(") ")
            ->__toString();

        $this->sql = $this->stb->append("values ")
            ->append("(")
            ->append($placeHolders)
            ->append(")")
            ->__toString();

        $this->sql = str_replace(",", ", ", $this->sql);
        return (string)$this->sql;
    }
}