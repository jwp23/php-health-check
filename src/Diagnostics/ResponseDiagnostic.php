<?php

namespace BB\WPHealthCheck\Diagnostics;

use GuzzleHttp\Psr7\Response;

abstract class ResponseDiagnostic extends SimpleDiagnostic implements
    AccessGuzzleResponseInterface
{
    protected $response;

    public function setGuzzleResponse(Response $response)
    {
        $this->response = $response;
    }

    public function getGuzzleResponse()
    {
        return $this->response;
    }
}
