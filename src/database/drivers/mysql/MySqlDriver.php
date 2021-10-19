<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 13:30
*/

namespace src\database\drivers\mysql;

use mysqli_stmt;
use src\database\drivers\AbstractDriver;
use src\database\helpers\DotEnvDBCredentials;

class MySqlDriver extends AbstractDriver
{

    const DRIVER_NAME = "MYSQLI";
    protected $connection;
    protected mysqli_stmt $stmt;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $mysqliCredentials = new DotEnvDBCredentials();
            $this->connection = mysqli_connect
            (
                $mysqliCredentials->getDbHost(),
                $mysqliCredentials->getDbUser(),
                $mysqliCredentials->getDbPass(),
                $mysqliCredentials->getDbName()
            );
        }
        catch (\mysqli_sql_exception $ex){
            throw new \mysqli_sql_exception(sprintf("[%s] Unable to connect mysql database, please check credentials", self::DRIVER_NAME));
        }
    }

    /**
     * Create mysqli prepared_statement object
     * @param string $query
     * @return $this
     */
    public function create_stmt(string $query): MySqlDriver
    {
        if (!$this->connection){
            throw new \mysqli_sql_exception(sprintf("[%s] Unable to connect mysql database, please check credentials", self::DRIVER_NAME));
        }

        if (empty($query)){
            throw new \mysqli_sql_exception(sprintf("[%s] Mysql query can't be empty", self::DRIVER_NAME));
        }

        $this->stmt = mysqli_stmt_init($this->connection);
        if(!$this->stmt->prepare($query)) {
            throw new \mysqli_sql_exception(sprintf("[%s] Can't prepare mysql query", self::DRIVER_NAME));
        }

        $this->stmt->prepare($query);
        return $this;
    }

    /**
     * Bind placeholders to the query
     * @param array $parameters
     * @return $this
     */
    public function bind_params(array $parameters): MySqlDriver{

        $placeholders = "";
        foreach ($parameters as $parameter){
            switch (gettype($parameter))
            {
                case "string":
                case "array":
                    $placeholders .= "s";
                    break;
                case "integer":
                    $placeholders .= "i";
                    break;
            }
        }

        $this->stmt->bind_param($placeholders, ...$parameters);
        return $this;
    }

    /**
     * Store data
     * @return array
     */
    public function store(): array{
        if (!$this->stmt){
            throw new \mysqli_sql_exception(sprintf("[%s] statement is null", self::DRIVER_NAME));
        }
        $execution = $this->stmt->execute();
        if (!$execution){
            throw new \mysqli_sql_exception(sprintf("[%s] Unable to execute stmt procedures", self::DRIVER_NAME));
        }

        return (array)$this->stmt->store_result();
    }

    /**
     * Select data
     * @return false|\mysqli_result
     */
    public function select(){
        if (!$this->stmt){
            throw new \mysqli_sql_exception(sprintf("[%s] statement is null", self::DRIVER_NAME));
        }
        $execution = $this->stmt->execute();
        if (!$execution){
            throw new \mysqli_sql_exception(sprintf("[%s] Unable to execute stmt procedures",self::DRIVER_NAME));
        }

        return $this->stmt->get_result();
    }

    /**
     * Delete data
     * @return bool
     */
    public function delete(): bool{
        if (!$this->stmt){
            throw new \mysqli_sql_exception(sprintf("[%s] statement is null", self::DRIVER_NAME));
        }
        if (!$this->stmt->execute()){
            throw new \mysqli_sql_exception(sprintf("[%s] Unable to execute stmt procedures",self::DRIVER_NAME));
        }

        return (bool)$this->stmt->execute();
    }


    /**
     * Return amount of
     * selected data
     * @return int
     */
    public function count(): int {
        if (!$this->stmt){
            throw new \mysqli_sql_exception(sprintf("[%s] statement is null", self::DRIVER_NAME));
        }
        if (!$this->stmt->execute()){
            throw new \mysqli_sql_exception(sprintf("[%s] Unable to execute stmt procedures",self::DRIVER_NAME));
        }

        $this->stmt->execute();
        $this->stmt->store_result();
        return (int)$this->stmt->num_rows();
    }

    /**
     * Return whether data exists
     * or not
     * @return bool
     */
    public function exists(): bool{
        $count = $this->count();
        if ($count > 0){
            return true;
        }
        return false;
    }

    /**
     * Check if client is connected
     * @return bool
     */
    public function isConnected(): bool {
        return !!$this->connection;
    }

    /**
     * Close Mysql connection
     * @return bool
     */
    public function closeConnection() : bool{
        if($this->connection){
            $this->stmt->close();
            return $this->connection->close();
        }
        return false;
    }

}