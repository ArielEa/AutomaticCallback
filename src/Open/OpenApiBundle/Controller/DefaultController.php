<?php

namespace Open\OpenApiBundle\Controller;

use Aia\Packages\HttpFoundation\Request;

class DefaultController
{
    public function defaultAction(Request $request)
    {
        return json_encode([
            "bundle_dir" => __DIR__,
            "target_file" => __FILE__,
            'environment' => "test"
        ], JSON_UNESCAPED_UNICODE);
    }
}
