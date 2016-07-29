<?php

namespace BB\WPHealthCheck\Diagnostics;

use BB\WPHealthCheck\DiagnosticCollection;
use BB\WPHealthCheck\DiagnosticContainer;
use BB\WPHealthCheck\Validation\Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\TransferStats;

class WebPageDiagnostics implements DiagnosticInterface
{
    /**
     * @var DiagnosticContainer
     */
    protected $diagnosticContainer;

    /**
     * @var TransferStats
     */
    protected $transferStats;

    /**
     * @var TransferStatsDiagnostic[]
     */
    protected $transferStatsDiagnostics = [];

    /**
     * @var ResponseDiagnostic[]
     */
    protected $responseDiagnostics = [];

    /**
     * @Assert\Type("string")
     */
    protected $description;

    /**
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     */
    protected $url;

    /**
     * @Assert\Type("integer")
     */
    protected $connectionTimeOutSecs;

    /**
     * @Assert\Type("integer")
     */
    protected $responseTimeOutSecs;

    protected $requestExceptionMessage;
    protected $diagnosticResult;
    protected $didDiagnosticPass;

    public function __construct(
        $description,
        $url = 'http://localhost',
        $connectionTimeOutSecs = 5,
        $responseTimeOutSecs = 5
    ) {
        $diagnosticCollection = new DiagnosticCollection();
        $this->diagnosticContainer = new DiagnosticContainer(
            $diagnosticCollection
        );
        $this->description = $description;
        $this->url = $url;
        $this->connectionTimeOutSecs = $connectionTimeOutSecs;
        $this->responseTimeOutSecs = $responseTimeOutSecs;

        Validator::validate($this);

        $this->requestExceptionMessage = 'Unable to connect to url ' .
            $this->url . ' because ';
    }

    public function addTransferStatsDiagnostic(
        TransferStatsDiagnostic $transferStatsDiagnostic
    ) {
        $this->transferStatsDiagnostics[] = $transferStatsDiagnostic;
        return $this;
    }

    public function addResponseDiagnostic(
        ResponseDiagnostic $responseDiagnostic
    ) {
        $this->responseDiagnostics[] = $responseDiagnostic;
        return $this;
    }

    public function getDiagnosticDescription()
    {
        return $this->description;
    }

    public function hasDiagnosticPassed()
    {
        if (isset($this->didDiagnosticPass)) {
            return $this->didDiagnosticPass;
        }

        return $this->diagnosticContainer->isApplicationHealthy();
    }

    public function getDiagnosticResult()
    {
        if (isset($this->diagnosticResult)) {
            return $this->diagnosticResult;
        }

        $results = [];
        foreach ($this->diagnosticContainer as $diagnostic) {
            $results[$diagnostic->getDiagnosticDescription()] =
                $diagnostic->getDiagnosticResult();
        }

        return $results;
    }

    public function runDiagnostic()
    {
        $transferStatsDiagnostics = $this->transferStatsDiagnostics;
        $responseDiagnostics = $this->responseDiagnostics;

        if ($transferStatsDiagnostics === [] && $responseDiagnostics === []) {
            throw new \Exception(
                '$transferStatsDiagnostics and $responseDiagnostics both empty'
            );
        }

        $client = new Client();
        try {
            $response = $client->request(
                'GET',
                $this->url,
                [
                    'http_errors' => false,
                    'connect_timeout' => $this->connectionTimeOutSecs,
                    'timeout' => $this->responseTimeOutSecs,
                    'on_stats' =>
                        function (TransferStats $transferStats) {
                            $this->transferStats = $transferStats;
                        },
                ]
            );
        } catch (RequestException $requestException) {
            $this->diagnosticResult = $this->requestExceptionMessage .
                $requestException->getMessage();
            $this->didDiagnosticPass = false;

            return;
        }

        $diagnosticContainer = $this->diagnosticContainer;
        if (isset($this->transferStats)) {
            foreach ($transferStatsDiagnostics as $diagnostic) {
                $diagnostic->setGuzzleTransferStats($this->transferStats);
                $diagnosticContainer->addDiagnostic($diagnostic);
            }
        }

        foreach ($responseDiagnostics as $diagnostic) {
            $diagnostic->setGuzzleResponse($response);
            $diagnosticContainer->addDiagnostic($diagnostic);
        }

        $diagnosticContainer->runFullDiagnostics();
    }
}
