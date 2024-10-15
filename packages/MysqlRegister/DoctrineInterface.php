<?php

namespace Aia\Packages\MysqlRegister;

interface DoctrineInterface
{
    public function insert($host, $sql);

    public function select($host, $sql);

    public function update($host, $sql);

    public function delete($host, $sql);
}
