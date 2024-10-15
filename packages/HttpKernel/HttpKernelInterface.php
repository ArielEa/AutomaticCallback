<?php

namespace Aia\Packages\HttpKernel;

use Aia\Packages\HttpFoundation\Request;
use Aia\Packages\HttpFoundation\Response;

interface HttpKernelInterface
{
    const MASTER_REQUEST = 1; // 主账号请求
    const SUB_REQUEST = 2; // 子账号请求
 
    /**
     * Handles a Request to convert it to a Response.
     *
     * When $catch is true, the implementation must catch all exceptions
     * and do its best to convert them to a Response instance.
     *
     * @param Request $request A Request instance
     * @param int $type    The type of the request
     *                         (one of HttpKernelInterface::MASTER_REQUEST or HttpKernelInterface::SUB_REQUEST)
     * @param bool $catch   Whether to catch exceptions or not
     *
     * @return Response A Response instance
     *
     * @throws \Exception When an Exception occurs during processing
     */
    public function handle(Request $request, int $type = self::MASTER_REQUEST, bool $catch = true): Response;
}
