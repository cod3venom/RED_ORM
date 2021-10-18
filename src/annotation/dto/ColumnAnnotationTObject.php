<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 18.10.2021
 * Time: 19:43
*/

namespace src\annotation\dto;


use InvalidArgumentException;

class ColumnAnnotationTObject
{
    public string $name;
    public string $type;
    public bool $nullable;
    public bool $ignore;
    public string $tableName;

    public function __construct(array $inputData)
    {
        if (!isset($inputData["name"])) {
            throw new InvalidArgumentException("Column must contain NAME annotation");
        }

        if (!isset($inputData["type"])) {
            throw new InvalidArgumentException("Column must contain TYPE annotation");
        }

        if (!isset($inputData["nullable"])) {
            throw new InvalidArgumentException("Column must contain NULLABLE annotation");
        }

        if (isset($inputData["table"])) {
            $this->tableName = $inputData["table"];
        }

        if (isset($inputData["ignore"])) {
            $this->ignore = $inputData["ignore"];
        }

        $this->name = $inputData["name"];
        $this->type = $inputData["type"];
        $this->nullable = $inputData["nullable"];
    }
}