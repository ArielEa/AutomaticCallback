<?php

namespace Aia\Packages\HttpKernel;

interface KernelInterface
{
    public function getEnvironment() :string;

    public function getContainer(): ContainerInterface;
}
