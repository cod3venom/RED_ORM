<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 06:39
*/

namespace src\query_builder;

use src\query_builder\helpers\Delete;
use src\query_builder\helpers\Insert;
use src\query_builder\helpers\Select;
use src\query_builder\helpers\Update;

class QueryBuilder
{
    public static function Insert(array $columns): Insert {
        return new Insert($columns);
    }

    public static function Select(array $columns): Select {
        return new Select($columns);
    }

    public static function Update(string $table): Update {
        return new Update($table);
    }

    public static function Delete(string $table): Delete {
        return new Delete($table);
    }
}