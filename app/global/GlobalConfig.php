<?php

namespace Aia\app\global;

abstract class GlobalConfig implements GlobalInterface
{
    public $environmen;

    public $sql_connection;

    public $project_secret;

    public $project_key;

    public function getEnvironment()
    {
        // TODO: Implement getEnvironment() method.
    }

    public function getSqlConnection()
    {
        // TODO: Implement getSqlConnection() method.
    }
}
