<?php

namespace Aia\Packages\HttpKernel\DependencyInjection;

use Aia\Packages\HttpKernel\DependencyFields\ContainerConfigFields;

/**
 * 用于保存配置信息， 以及服务信息
 * config.parameters - [config], [config_dev], [config_prod], [config_test]
 * service.parameters - [services]
 * Class KernelContainerParameters
 * @package Aia\Packages\HttpKernel\DependencyInjection
 */
class KernelContainerParameters
{
    private static $kernelContainerParametersInstance = null;

    public static array $parameters_yaml_storage;

    private function __clone(){}

    private function __construct($configName, $configMessages, $exact)
    {
        self::initializeStorage($configName, $configMessages, $exact);
    }

    public static function SetStorage(string $configName, array $configMessages, string $exact = ""): ?KernelContainerParameters
    {
        if (empty(self::$parameters_yaml_storage) || $exact) {
            self::$kernelContainerParametersInstance = new self($configName, $configMessages, $exact);
        }
        return self::$kernelContainerParametersInstance;
    }

    public static function GetStorage(string $configName)
    {
        return self::$parameters_yaml_storage[$configName];
    }

    public static function HasStorage(): bool
    {
        return isset(self::$kernelContainerParametersInstance);
    }

    public static function interpositionStorage(string $configName, array $configMessage): bool
    {
        self::SetStorage($configName, $configMessage, ContainerConfigFields::KERNEL_CONTAINER_PARAMETERS_INSERT);

        return true;
    }

    public static function updateStorage(string $configName, array $configMessage, string $exact): ?KernelContainerParameters
    {
        return self::SetStorage($configName, $configMessage, ContainerConfigFields::KERNEL_CONTAINER_PARAMETERS_UPDATE);
    }

    public static function removeStorage(string $configName, array $configMessage): bool
    {
        self::SetStorage($configName, $configMessage, ContainerConfigFields::KERNEL_CONTAINER_PARAMETERS_REMOVE);
        return true;
    }

    private static function initializeStorage($configName, $configMessages, $exact)
    {
        switch ($exact) {
            case ContainerConfigFields::KERNEL_CONTAINER_PARAMETERS_INSERT:
                self::inset($configName, $configMessages, $exact);
                break;
            case ContainerConfigFields::KERNEL_CONTAINER_PARAMETERS_UPDATE:
                self::update($configName, $configMessages);
                break;
            case ContainerConfigFields::KERNEL_CONTAINER_PARAMETERS_REMOVE:
                self::remove();
                break;
            case ContainerConfigFields::KERNEL_CONTAINER_PARAMETERS_SET_NEW:
                self::inset($configName, $configMessages, ContainerConfigFields::KERNEL_CONTAINER_PARAMETERS_SET_NEW);
                break;
            default:
                throw new \Exception("invalid");
        }
    }

    private static function inset(string $configName, array $configMessages, string $currentStatus)
    {
        self::$parameters_yaml_storage[$configName] = $configMessages;
    }

    private static function update(string $configName, array $configMessages)
    {
        $current_parameters = self::$parameters_yaml_storage;

        $update_parameters = $configMessages;

        if (!empty($current_parameters)) {
            if (isset($current_parameters[$configName])) {
                $update_parameters = array_merge($current_parameters[$configName], $configMessages);
            }
        }
        self::$parameters_yaml_storage[$configName] = $update_parameters;
    }

    private static function remove()
    {

    }

    private static function merge()
    {

    }
}
