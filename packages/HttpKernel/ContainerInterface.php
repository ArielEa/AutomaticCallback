<?php

namespace Aia\Packages\HttpKernel;

/**
 * Interface ContainerInterface
 * @author Ariel. <ariel673770@gmail.com>
 * @package Aia\Packages\HttpKernel
 */
interface ContainerInterface
{
    /**
     * @param string $key - a service's name
     * @param object $service - a service from project
     * @return mixed
     */
    public function set(string $key, object $service);

    /**
     * get a service  from a pool with some registered services.
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * Determine whether the selected service exists!
     * @param string $key
     * @return mixed
     */
    public function has(string $key);

    /**
     * Check for whether or not a service has been initialized.
     *
     * @param string $id
     * @return mixed
     */
    public function initialized(string $id);

    /**
     * get some information from registered service parameters.
     * @param string $name
     * @return mixed
     */
    public function getParameter(string $name);

    /**
     * Determine whether the current service parameter exists!
     * @param string $name
     * @return mixed
     */
    public function hasParameter(string $name);

    /**
     * set a parameter.
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function setParameter(string $name, $value);
}
