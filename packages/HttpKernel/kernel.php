<?php

namespace Aia\Packages\HttpKernel;

use Aia\app\global\environment;
use Aia\Packages\HttpFoundation\Request;
use Aia\Packages\HttpFoundation\Response;
use Aia\Packages\HttpKernel\DependencyInjection\KernelBuilder;
use Aia\Packages\HttpKernel\HttpKernelInterface;

class kernel extends KernelBuilder implements HttpKernelInterface, TerminableInterface
{
    protected string $environment;
    protected string $debug;

    const JSON_HEADER = "application/json";
    CONST XML_HEADER = "application/xml";

    /**
     * Constructor.
     * @param bool $debug       Whether to enable debugging or not
     */
    public function __construct(bool $debug)
    {
        $this->debug = $debug;
    }

    /**
     * 作用:: 这一步用来处理容器
     * 说明:: 存储一些一开始会使用到的服务，比如，数据库（当前项目支持mysql）, 将方法映射进入容器，后可以直接使用并且注入
     * 优先级:: 优先读取数据库类 EntityManager, EntityManagerInterface
     *         注入服务容器 Kernel, KernelInterface, ContainerInterface
     *         验证项目内后添加的服务类方法 Services.yaml from project
     * @param Request $request
     * @param int $type
     * @param bool $catch
     * @return Response
     */
    public function handle(Request $request, int $type = self::MASTER_REQUEST, bool $catch = true): Response
    {
        ## fixme 优先判断当前环境
        ## fixme 写入全局参数，从get，post中获取的数据
        ## fixme 其次注入容器
        ## fixme 最后注册数据库

        var_dump(123123123);die;

        print_r( $request );
//
        die;
        return new Response();
    }

    public function container(string $environment)
    {
    }

    /**
     * 作用:: 发射路由，请求到使用类
     * {@inheritdoc}
     */
    public function terminate(Request $request, Response $response)
    {
        $this->terminate_style($request, $response);
    }

    public function terminate_style($request, $response)
    {
        $responseType = gettype($response);

        if (strtoupper($responseType) != "STRING") {
            $this->systemErrorReturned();
        }
        $jsonAttribute = json_decode($response, true);

        if (!is_null($jsonAttribute)) {
            header("Content-Type:".self::JSON_HEADER);
        } else {
            $xmlParse = xml_parser_create();

            $xmlAttribute = xml_parse($xmlParse, $response, true);

            xml_parser_free($xmlParse);

            if (!$xmlAttribute) {
                $this->systemErrorReturned();
            }
            header("Content-Type:".self::XML_HEADER);
        }
        echo $response;
    }

    private function systemErrorReturned()
    {
        header("Content-Type:".self::JSON_HEADER);
        echo json_encode([
            "code" => 400,
            "flag" => "failure",
            "message" => "当前返回值并不是标准格式[xml,json]"
        ],JSON_UNESCAPED_UNICODE);
        exit();
    }
}
