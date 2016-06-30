<?php


namespace BB\WPHealthCheck;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SendJsonResponseHealthCheckFactory extends HealthCheckFactory
{
    /**
     * @var JsonResponse
     */
    protected $jsonResponse;

    public function __construct(
        $healthOkStatusMessage,
        $healthNotOkStatusMessage,
        JsonResponse $jsonResponse
    ) {
        parent::__construct($healthOkStatusMessage, $healthNotOkStatusMessage);
        $this->jsonResponse = $jsonResponse;
    }

    protected function sendJsonResponse($data, $statusCode)
    {
        $jsonResponse = $this->jsonResponse;
        $jsonResponse->setData($data);
        $jsonResponse->setStatusCode($statusCode);
        $jsonResponse->prepare(Request::createFromGlobals());
        $jsonResponse->setEncodingOptions(JSON_PRETTY_PRINT);
        $jsonResponse->send();
    }

    protected function getHealthCheckData()
    {
        $healthStatusMessage = $this->healthNotOkStatusMessage;
        $statusCode = self::HEALTH_NOT_OK_CODE;

        if ($this->diagnosticContainer->isApplicationHealthy()) {
            $healthStatusMessage = $this->healthOkStatusMessage;
            $statusCode = self::HEALTH_OK_CODE;
        }

        $data = new \stdClass();
        $data->status = $statusCode;
        $data->message = $healthStatusMessage;

        return $data;
    }

    public function displayHealthCheckReport()
    {
        $this->diagnosticContainer->runFullDiagnostics();
        $healthCheckData = $this->getHealthCheckData();

        $this->sendJsonResponse($healthCheckData, $healthCheckData->status);
    }

    public function displayStatusCheckReport()
    {
        $diagnosticContainer = $this->diagnosticContainer;
        $diagnosticContainer->runDiagnosticsUntilFail();

        $statusCheckData = $this->getHealthCheckData();
        $results = [];
        foreach ($diagnosticContainer as $diagnostic) {
            $results[$diagnostic->getDiagnosticDescription()] =
                $diagnostic->getDiagnosticResult();
        }

        $statusCheckData->statusChecks = $results;

        $this->sendJsonResponse($statusCheckData, JsonResponse::HTTP_OK);
    }
}
