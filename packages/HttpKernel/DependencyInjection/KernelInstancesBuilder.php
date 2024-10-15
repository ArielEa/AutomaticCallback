<?php

namespace Aia\Packages\HttpKernel\DependencyInjection;

final class KernelInstancesBuilder
{
    public static array $ContainerInstances;

    public static function set($InstancesName, $interface)
    {
        self::$ContainerInstances[$InstancesName] = $interface;
    }

    public static function get(string $key)
    {
        return self::$ContainerInstances[$key];
    }

    public static function has(string $key)
    {
        return isset(self::$ContainerInstances[$key]);
    }
}
