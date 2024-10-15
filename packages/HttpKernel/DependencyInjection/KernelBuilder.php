<?php

namespace Aia\Packages\HttpKernel\DependencyInjection;

use Aia\app\global\Environment;
use Aia\Packages\HttpKernel\ContainerInterface;
use Aia\Packages\HttpKernel\KernelInterface;

class KernelBuilder implements KernelInterface
{
    public function __construct()
    {
        $this->initialize();
    }

    public function initialize()
    {
    }

    public function getEnvironment(): string
    {
        return Environment::getEnvironment();
    }

    public function getContainer(): ContainerInterface
    {
        if (KernelInstancesBuilder::has("container")) {
            return KernelInstancesBuilder::get("container");
        }
        KernelInstancesBuilder::set('container', new ContainerBuilder());

        return KernelInstancesBuilder::get('container');
    }

    public static function createKernelFactory(): KernelBuilder
    {
        return new self();
    }
}
