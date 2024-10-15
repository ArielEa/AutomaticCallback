<?php

namespace Aia\Packages\MysqlRegister;

interface EntityManagerInterface
{
    public function getRepository($entityName);
}
