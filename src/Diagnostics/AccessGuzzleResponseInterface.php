<?php

namespace BB\WPHealthCheck\Diagnostics;

use GuzzleHttp\Psr7\Response;

interface AccessGuzzleResponseInterface
{
    /**
     * @param Response $response
     * @return void
     */
    public function setGuzzleResponse(Response $response);

    /**
     * @return Response
     */
    public function getGuzzleResponse();
}
