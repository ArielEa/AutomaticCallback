<?php

namespace Aia\Packages\HttpKernel\DependencyInjection;

use Aia\app\global\Environment;
use Aia\Packages\HttpKernel\ContainerInterface;
use Aia\Packages\HttpKernel\DependencyInjection\Bags\ParametersBags;

class ContainerBuilder implements ContainerInterface
{
    public array $analysisData = [];

    public function set(string $key, object $service)
    {
    }

    /**
     * 获取服务方法信息
     */
    public function get(string $key)
    {
        return $key;
    }

    public function has(string $key)
    {
    }

    public function initialized(string $id)
    {
    }

    public function setParameter(string $name, $value)
    {
    }

    /**
     * 返回配置信息
     */
    public function getParameter(string $name)
    {
        return ParametersBags::getParameterByConsoleName($name);
    }

    public function hasParameter(string $name)
    {
    }

    public function __construct()
    {
        $this->initializeService();
    }

    /**
     * Read the yaml file under the directory app.
     */
    public function initializeService()
    {
    }
}
