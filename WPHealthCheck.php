<?php

namespace BB\WPHealthCheck;

use SplFileObject;
use Symfony\Component\HttpFoundation\JsonResponse;

class WPHealthCheck
{

    const STATUS_OK_MESSAGE = "OK";
    const STATUS_NOT_OK_MESSAGE = "NOT OK";
    const HTTP_OK = 200;
    const HTTP_BAD = 400;
    const CHECK_PASS_MESSAGE = "OK";
    const CHECK_NOT_PASS_MESSAGE = "NOT OK";

    /**
     * @var SplFileObject
     */
    private $webRootDir;

    /**
     * @var SplFileObject
     */
    private $wordPressRootDir;

    /**
     * @var SplFileObject
     */
    private $wordPressConfigFile;

    /**
     * @var SplFileObject
     */
    private $wpActivateFile;
    
    /**
     * @var JsonResponse
     */
    private $jsonResponse;
    
    /**
     * @var int
     */
    private $responseTimeMs;
    
    private $canWordPressConnectToDb = false;
    private $canAppServerConnectToDb = false;

    public function __construct(
        SplFileObject $webRootDir,
        SplFileObject $wordPressRootDir,
        SplFileObject $wordPressConfigFile,
        JsonResponse $jsonResponse,
        $responseTimeMs = 2000,
        array $buildInfo = []
    ) {
        $this->webRootDir       = $webRootDir;
        $this->wordPressRootDir = $wordPressRootDir;
        $this->wordPressConfigFile = $wordPressConfigFile;
        $this->jsonResponse   = $jsonResponse;
        $this->responseTimeMs = $responseTimeMs;
    }

    public function healthCheck()
    {

    }

    public function statusCheck()
    {

    }
}
