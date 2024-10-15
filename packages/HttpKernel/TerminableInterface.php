<?php

namespace Aia\Packages\HttpKernel;

use Aia\Packages\HttpFoundation\Request;
use Aia\Packages\HttpFoundation\Response;

/**
 * Terminable extends the Kernel request/response cycle with dispatching a post
 * response event after sending the response and before shutting down the kernel.
 */
interface TerminableInterface
{
    /**
     * Terminates a request/response cycle.
     *
     * Should be called after sending the response and before shutting down the kernel.
     *
     * @param Request  $request  A Request instance
     * @param Response $response A Response instance
     */
    public function terminate(Request $request, Response $response);
}
