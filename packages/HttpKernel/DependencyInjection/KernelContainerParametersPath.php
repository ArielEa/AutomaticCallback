<?php

namespace Aia\Packages\HttpKernel\DependencyInjection;

use Aia\app\global\Environment;
use Aia\Packages\HttpKernel\DependencyFields\ContainerConfigFields;

/**
 * [config.yml] must be analyzed
 * [PROD/DEV]Check current system environment and read this environment files.
 */
class KernelContainerParametersPath
{
    private static string $defaultConfigFileNamePrefix = "config";

    private static string $defaultConfigFileAttribute = "yml";

    private static $parameters_config_path;

    private static string $config_file_path;

    private static string $environment;

    private function __construct()
    {
        self::analysisFilesAndReturn();
    }

    private function __clone() {}

    public static function setConfigInstances(): KernelContainerParametersPath
    {
        if (self::$parameters_config_path == null) {
            self::$parameters_config_path = new self;
        }
        return self::$parameters_config_path;
    }

    private function analysisFilesAndReturn()
    {
        self::getConfigFilePath();
        self::getEnvironment();
        self::getExplainConfigFiles();
    }

    private static function getExplainConfigFiles()
    {
        $defaultMainConfigFile = self::$defaultConfigFileNamePrefix.".".self::$defaultConfigFileAttribute;

        $defaultEnvironmentConfigFile = self::$defaultConfigFileNamePrefix."_".self::$environment.".".self::$defaultConfigFileAttribute;

        self::getConfigFiles($defaultEnvironmentConfigFile, $defaultMainConfigFile);
    }

    private static function getConfigFiles(string $defaultEnvironmentConfigFile, string $defaultMainConfigFile)
    {
        $fileEnvironmentFullPath = self::$config_file_path.$defaultEnvironmentConfigFile;

        $fileMainFullPath = self::$config_file_path.$defaultMainConfigFile;

        # if the environment config file is not exist. Find the config main file [config.yml]. Get null throw Error messages.
        if (!is_file($fileEnvironmentFullPath)) {
            if (!is_file($fileMainFullPath)) {
                throw new \Exception("config main parameters must be declare");
            } else {
                throw new \Exception("config file is not found!");
            }
        }

        self::readConfigFilesParameters($fileEnvironmentFullPath, $fileMainFullPath);
    }

    /**
     * if parameters are both in [config] and [config_dev/prod], the primary data is in the [config_dev/prod] file.
     * import: if not null, source new files and analysis data.
     * parameters: parameters.
     */
    private static function readConfigFilesParameters(string $fileEnvironmentFullPath, string $fileMainFullPath)
    {
        $fileMainFullPathParameters = \Spyc::YAMLLoad($fileMainFullPath);

        if (isset($fileMainFullPathParameters['imports']) &&
            !empty($fileMainFullPathParameters['imports']))
        {
            self::sourceImportFilesAndRecordParameters($fileMainFullPathParameters['imports']);
        }

        if (isset($fileMainFullPathParameters['parameters']) &&
            !empty($fileMainFullPathParameters['parameters']))
        {
            self::SetConfigPathData($fileMainFullPathParameters['parameters']);
        }

        $fileEnvironmentFullPathParameters = \Spyc::YAMLLoad($fileEnvironmentFullPath);

        if (isset($fileEnvironmentFullPathParameters['imports']) &&
            !empty($fileEnvironmentFullPathParameters['imports']))
        {
            self::sourceImportFilesAndRecordParameters($fileEnvironmentFullPathParameters['imports']);
        }

        if (isset($fileEnvironmentFullPathParameters['parameters']) &&
            !empty($fileEnvironmentFullPathParameters['parameters']))
        {
            self::SetConfigPathData($fileEnvironmentFullPathParameters['parameters']);
        }
    }

    private static function getEnvironment()
    {
        self::$environment = Environment::getEnvironment();
    }

    private static function getConfigFilePath()
    {
        self::$config_file_path = dirname(__DIR__)."/../../app/config/";
    }

    private static function sourceImportFilesAndRecordParameters(array $imports)
    {
        $importsAlias = "config.imports";

        $exact = KernelContainerParameters::HasStorage() ?
            ContainerConfigFields::KERNEL_CONTAINER_PARAMETERS_UPDATE :
            ContainerConfigFields::KERNEL_CONTAINER_PARAMETERS_SET_NEW;

        KernelContainerParameters::SetStorage($importsAlias, $imports, $exact);

        if (empty($importsAlias)) {
            return;
        }

        self::sourceImportFilesParametersDraw($imports);
    }

    private static function sourceImportFilesParametersDraw(array $imports)
    {
        // 如果当前文件没有前缀，那么认定当前文件是同级目录.
        foreach ($imports as $key => $value) {
            $importsFilePath = self::$config_file_path.$value;

            $importsFileParameters = \Spyc::YAMLLoad($importsFilePath);

            if (empty($importsFileParameters)) continue;

            if (isset($importsFileParameters['imports']) && !empty($importsFileParameters['imports'])) {
                self::sourceImportFilesAndRecordParameters($importsFileParameters['imports']);
            }
            if (!isset($importsFileParameters['parameters']) && !empty($importsFileParameters['parameters']))
                continue;

            self::SetConfigPathData($importsFileParameters['parameters']);
        }
    }

    private static function SetConfigPathData(array $parameters)
    {
        $storageAlias = "config.parameters";

        $exact = KernelContainerParameters::HasStorage()?
            ContainerConfigFields::KERNEL_CONTAINER_PARAMETERS_UPDATE  :
            ContainerConfigFields::KERNEL_CONTAINER_PARAMETERS_SET_NEW;

        KernelContainerParameters::SetStorage($storageAlias, $parameters, $exact);
    }
}
