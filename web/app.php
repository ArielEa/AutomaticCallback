<?php

use Aia\Packages\HttpFoundation\Request;

date_default_timezone_set("Asia/Shanghai");

umask(0002);

define("C_ROOT_PATH", dirname(__DIR__));

include dirname(__DIR__)."/vendor/autoload.php";

$kernel = new AppKernel(false);

$request = Request::createFromGlobal();

$response = $kernel->handle($request); // 路由接口返回的信息

$kernel->terminate($request, $response); // 将路由信息转换成相应格式
