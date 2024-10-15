<?php

namespace Aia\app\global;

abstract class Environment
{
    public static string $rootPath;

    // fixme 如果没有test文件，需要验证当前文件是否存在，否则直接500
    const PROD_FILE_NAME = ".env";

    // fixme 此文件位最优先, test文件
    const DEV_FILE_NAME = ".env.local.php";

    const DEV_ENVIRONMENT = "dev";

    const PROD_ENVIRONMENT = "prod";

    const ENVIRONMENT_FILES = [
        self::DEV_ENVIRONMENT => self::DEV_FILE_NAME,
        self::PROD_ENVIRONMENT => self::PROD_FILE_NAME
    ];

    public static function getEnvironmentSqlFile(string $environment): string
    {
        if (!isset(self::ENVIRONMENT_FILES[$environment])) {
            throw new \Exception("Invalid Type： {$environment}");
        }

        return self::ENVIRONMENT_FILES[$environment];
    }

    public static function getEnvironment(): string
    {
        self::$rootPath = dirname(dirname(__DIR__))."/";

        return self::getFileInfo();
    }

    private static function getFileInfo(): string
    {
        $devExists = file_exists(self::$rootPath.self::DEV_FILE_NAME);

        if ($devExists) {
            return self::DEV_ENVIRONMENT;
        }
        $prodExists = file_exists(self::$rootPath.self::PROD_FILE_NAME);

        if ($prodExists) {
            return self::PROD_ENVIRONMENT;
        }
        throw new \Exception("Error Environment");
    }

    private static function prod()
    {

    }

    private static function dev()
    {

    }
}
