<?php

namespace Aia\app\global;

interface GlobalInterface
{
    public function getSqlConnection();

    public function getEnvironment();
}
