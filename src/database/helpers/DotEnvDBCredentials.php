<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 14:50
*/

namespace src\database\helpers;

class DotEnvDBCredentials
{
    private string $db_host;
    private string $db_user;
    private string $db_pass;
    private string $db_name;


    public function __construct()
    {
        $this->db_host = getenv("MYSQL_DB_HOST");
        $this->db_user = getenv("MYSQL_DB_USER");
        $this->db_pass = getenv("MYSQL_DB_PASSWORD");
        $this->db_name = getenv("MYSQL_DB_NAME");
    }

    /**
     * @return string
     */
    public function getDbHost(): string
    {
        return $this->db_host;
    }

    /**
     * @return string
     */
    public function getDbUser(): string
    {
        return $this->db_user;
    }

    /**
     * @return string
     */
    public function getDbPass(): string
    {
        return $this->db_pass;
    }

    /**
     * @return string
     */
    public function getDbName(): string
    {
        return $this->db_name;
    }
}