<?php

namespace Aia\Packages\MysqlRegister;

class SqlConstructorInstances
{
    public static $sqlInstances = null;

    public static function setInstances(\PDO $sqlBuilder)
    {
        if (self::$sqlInstances == null) {
            self::$sqlInstances = $sqlBuilder;
        }

        return self::$sqlInstances;
    }
}
