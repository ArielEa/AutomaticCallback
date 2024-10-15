<?php

namespace Aia\Packages\HttpKernel\DependencyInjection\Bags;

use Aia\Packages\HttpKernel\DependencyInjection\KernelContainerParameters;

/**
 * Parameters 只会存储在 config.parameters 中
 * Services 配置文件只会存储服务类信息
 */
abstract class ParametersBags
{
    public static function getParameterByConsoleName(string $name)
    {
        $configParameters = KernelContainerParameters::$parameters_yaml_storage;

        if (empty($configParameters)) {
            return false;
        }

        $parameters = $configParameters['config.parameters'];

        if (empty($parameters)) {
            return false;
        }

        if (!isset($parameters[$name])) {
            throw new \Exception("Invalid config name");
        }

        return $parameters[$name];
    }
}
