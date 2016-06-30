<?php

namespace BB\WPHealthCheck;

use BB\WPHealthCheck\Diagnostics\ResponseStatusCodeDiagnostic;
use BB\WPHealthCheck\Diagnostics\StringNotInResponseDiagnostic;
use BB\WPHealthCheck\Diagnostics\TransferTimeDiagnostic;
use BB\WPHealthCheck\Diagnostics\WebPageDiagnostics;
use BB\WPHealthCheck\Validation\Validator;

class WordPressPageLoadCheck extends SubSystemCheck
{

    /**
     * @Assert\Type("string")
     */
    protected $relativeURLToCheck;

    /**
     * @Assert\Type("integer")
     */
    protected $expectedTransferTimeSecs;

    /**
     * @Assert\Type("integer")
     */
    protected $connectionTimeOutSecs;

    /**
     * @Assert\Type("integer")
     */
    protected $responseTimeOutSecs;
    
    public function __construct()
    {
        parent::__construct(new DiagnosticCollection());
    }
    
    public function setRelativeURLTocheck($relativeURLToCheck = 'wp-activate.php')
    {
        $this->relativeURLToCheck = $relativeURLToCheck;
        return $this;
    }
    
    public function setExpectedTransferTimeSecs($expectedTransferTimeSecs = 2)
    {
        $this->expectedTransferTimeSecs = $expectedTransferTimeSecs;
        return $this;
    }
    
    public function setConnectionTimeOutSecs($connectionTimeOutSecs = 5)
    {
        $this->connectionTimeOutSecs = $connectionTimeOutSecs;
        return $this;
    }
    
    public function setResponseTimeOutSecs($responseTimeOutSecs = 5)
    {
        $this->responseTimeOutSecs = $responseTimeOutSecs;
        return $this;
    }
    
    public function constructSubSystemDiagnostics()
    {
        Validator::validate($this);

        $urlForWebPageDiagnostic = 'http://localhost/' .
            ltrim($this->relativeURLToCheck, '/');

        $statusCodeCheck = new ResponseStatusCodeDiagnostic(
            'Url ' . $urlForWebPageDiagnostic . ' loaded with status code 200'
        );
        $wpDBConnectionErrorMsg = 'Error Establishing a Database Connection';
        $stringNotInWebPageCheck = new StringNotInResponseDiagnostic(
            "\"${wpDBConnectionErrorMsg}\" not found on page",
            $wpDBConnectionErrorMsg
        );
        $transferTimeCheck = new TransferTimeDiagnostic(
            'Transfer time was less than ' . $this->expectedTransferTimeSecs .
            ' seconds',
            $this->expectedTransferTimeSecs
        );
        $wpPageLoadDiagnostics = new WebPageDiagnostics(
            "Loading WordPress page {$urlForWebPageDiagnostic} results",
            $urlForWebPageDiagnostic,
            $this->connectionTimeOutSecs,
            $this->responseTimeOutSecs
        );

        $wpPageLoadDiagnostics
            ->addResponseDiagnostic($statusCodeCheck)
            ->addResponseDiagnostic($stringNotInWebPageCheck)
            ->addTransferStatsDiagnostic($transferTimeCheck);
        
        $this->diagnosticCollection->addDiagnostic($wpPageLoadDiagnostics);
    }
}
