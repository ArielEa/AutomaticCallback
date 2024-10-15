<?php

namespace Aia\Packages\MysqlRegister;

use Aia\app\global\Environment;
use MillionMile\GetEnv\Env;

class SqlBuilder
{
    private function __construct()
    {
        self::getEnvironment();
        self::getConfigFilePath();
        self::initializeSql();
    }

    private function __clone(){}

    private static $sqlSqlInstances = null;

    private static string $environment;

    private static string $sql_files_path;

    public static function setSqlInstances(): ?SqlBuilder
    {
        if (self::$sqlSqlInstances == null) {
            self::$sqlSqlInstances = new self();
        }
        return self::$sqlSqlInstances;
    }

    private static function getConfigFilePath()
    {
        self::$sql_files_path = Environment::$rootPath;
    }

    private static function getEnvironment()
    {
        self::$environment = Environment::getEnvironment();
    }

    private static function initializeSql()
    {
        self::sqlConfigureFile();
    }

    private static function sqlConfigureFile()
    {
        $file = Environment::getEnvironmentSqlFile(self::$environment);

        $fullSqlFilePath = self::$sql_files_path.$file;

        $configureMessages = self::$environment == Environment::DEV_ENVIRONMENT ?
            self::getDevFileMessages($fullSqlFilePath) :
            self::getEnvFileMessages($fullSqlFilePath);

        SqlConstructorInstances::setInstances($configureMessages);
    }

    /**
     * @param string $fullSqlFilePath
     * @return \PDO
     * @throws \Exception
     */
    private static function getEnvFileMessages(string $fullSqlFilePath): \PDO
    {
        if (empty(Env::get("DATABASE_DSN"))) {
            throw new \Exception("DATABASE DNS is null");
        }
        $dbMessage['DATABASE_DSN'] = Env::get("DATABASE_DSN");

        if (empty(Env::get("DATABASE_USER"))) {
            throw new \Exception("DATABASE_USER DNS is null");
        }
        $dbMessage['DATABASE_USER'] = Env::get("DATABASE_USER");

        if (empty(Env::get("DATABASE_PWD"))) {
            throw new \Exception("DATABASE_PWD DNS is null");
        }
        $dbMessage['DATABASE_PWD'] = Env::get("DATABASE_PWD");

        $dbMessage['DATABASE_CHARSET'] = Env::get("DATABASE_CHARSET");

        $dbMessage['DATABASE_VERSION'] = Env::get("DATABASE_VERSION");

        return self::connectSql($dbMessage);
    }

    /**
     * @param string $fullSqlFilePath
     * @return \PDO
     * @throws \Exception
     */
    private static function getDevFileMessages(string $fullSqlFilePath): \PDO
    {
        if (!is_file($fullSqlFilePath)) {
            throw new \Exception("The sql configure file .env.local.php is not find");
        }
        $dbMessage = @include_once($fullSqlFilePath);

        if (empty($dbMessage) || gettype($dbMessage) == 'integer') {
            throw new \Exception("db message is null");
        }

        return self::connectSql($dbMessage);
    }

    /**
     * @param array $dbMessage
     * @return \PDO
     */
    private static function connectSql(array $dbMessage): \PDO
    {
        try {
            $connection = new \PDO($dbMessage['DATABASE_DSN'], $dbMessage['DATABASE_USER'], $dbMessage['DATABASE_PWD']);
        } catch (\PDOException $e) {
            throw new  ("Sql Error!: " . $e->getMessage());
        }
        return $connection;
    }
}
