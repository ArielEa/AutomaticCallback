<?php

use Aia\Packages\HttpKernel\kernel;
use Aia\Packages\HttpKernel\DependencyInjection\KernelContainerParametersPath;
use Aia\Packages\MysqlRegister\SqlBuilder;

/**
 * 初始化一些信息
 * kernel 容器
 * services 服务
 * mysql 数据库
 * Class AppKernel
 */
class AppKernel extends kernel
{
    public $name;

    public $rootDir;

    public $startTime;

    public function __construct(bool $debug)
    {
        parent::__construct($debug);
        $this->initialize();
    }

    public function initialize()
    {
        $this->rootDir = $this->getRootDir();
        $this->name = $this->getName();

        if ($this->debug) {
            $this->startTime = microtime(true);
        }
        $this->initializeSql();
        $this->initializeConfigParameters();

        $res= $this->getCacheDir();

//        $str = $this->getContainer()->getParameter("local");

    }

    /**
     * 水平有限， 目前只支持mysql
     */
    private function initializeSql()
    {
       SqlBuilder::setSqlInstances();
    }

    /**
     * 获取当前配置文件中设置的配置信息, 不处理php类
     */
    private function initializeConfigParameters()
    {
        KernelContainerParametersPath::setConfigInstances();
    }

    /**
     * 处理预先设置的php类
     */
    private function initializeServiceParameters()
    {

    }

    /**
     * 整理当前已经拥有的bundle，要做到自动填充
     * 说明:: 后期需要用bin/console 自动生成bundle
     * @return array
     */
    public function registerBundle(): array
    {
        $bundles = [];

        return [];
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getName()
    {
        if (null === $this->name) {
            $this->name = preg_replace('/[^a-zA-Z0-9_]+/', '', basename($this->rootDir));

            if (ctype_digit($this->name[0])) {
                $this->name = '_'.$this->name;
            }
        }
        return $this->name;
    }

    public function getCacheDir(): string
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment()."/";
    }

    public function getLogDir(): string
    {
        return dirname(__DIR__).'/var/logs';
    }
}
