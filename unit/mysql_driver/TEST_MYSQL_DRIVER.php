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
use src\RedORM;
use src\test_models\UserProfile;

class TEST_MYSQL_DRIVER extends TestCase
{
    private function configureEnv(){
        $_ENV["MYSQL_DB_HOST"]="localhost";
        $_ENV["MYSQL_DB_USER"]="root";
        $_ENV["MYSQL_DB_PASSWORD"]= "";
        $_ENV["MYSQL_DB_NAME"]="RED_ORM";

        foreach ($_ENV as $key=>$value) {
            putenv(sprintf('%s=%s', $key, $value));
        }
    }


    public function testCheckConnection() {
        $this->configureEnv();
        $connectionObj = new DotEnvDBCredentials();
        $this->assertNotEmpty($connectionObj->getDbHost());
        $this->assertNotEmpty($connectionObj->getDbName());
        $this->assertNotEmpty($connectionObj->getDbUser());

        $mysqli = new MySqlDriver($connectionObj);
        $this->assertTrue($mysqli->isConnected());
    }

    public function testMySql_INSERT(){
        $this->configureEnv();

        $profile = new UserProfile();
        $profile->userEmail = "admin@gmail.com";
        $profile->userStatus = "off";

        $result = RedORM::Connect()
            ->adoptClass(UserProfile::class)
            ->Insert()
            ->getDriver()
            ->bind_params([$profile->userEmail, $profile->userStatus])
            ->store();

        $result = RedORM::Connect()
            ->adoptTable("user_profile")
            ->adoptColumns(["EMAIL", "STATUS"])
            ->Insert()
            ->getDriver()
            ->bind_params(["test@gmail.com", "on"])
            ->store();
        var_dump($result);
     }

    public function testMySql_SELECT(){
        $this->configureEnv();

        $result = RedORM::Connect()
            ->adoptClass(UserProfile::class)
            ->Select()
            ->where("ID")
            ->greaterThan();


    }
}