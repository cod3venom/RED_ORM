<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 15:06
*/

namespace unit\mysql_driver;

require "../../vendor/autoload.php";
use PHPUnit\Framework\TestCase;
use src\database\drivers\mysql\MySqlDriver;
use src\database\helpers\DotEnvDBCredentials;

class TEST_MYSQL_DRIVER extends TestCase
{
    public function testCheckConnection() {
        $_ENV["MYSQL_DB_HOST"]="localhost";
        $_ENV["MYSQL_DB_USER"]="root";
        $_ENV["MYSQL_DB_PASSWORD"]= "";
        $_ENV["MYSQL_DB_NAME"]="cdproject-gmaps";

        foreach ($_ENV as $key=>$value) {
            putenv(sprintf('%s=%s', $key, $value));
        }

        $connectionObj = new DotEnvDBCredentials();
        $this->assertNotEmpty($connectionObj->getDbHost());
        $this->assertNotEmpty($connectionObj->getDbName());
        $this->assertNotEmpty($connectionObj->getDbUser());

        $mysqli = new MySqlDriver($connectionObj);
        $this->assertTrue($mysqli->isConnected());
    }
}