<?php

namespace BB\WPHealthCheck;

use BB\WPHealthCheck\Diagnostics\DiagnosticInterface;
use BB\WPHealthCheck\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use InvalidArgumentException;

abstract class HealthCheckFactory
{

    const HEALTH_OK_CODE = JsonResponse::HTTP_OK;
    const HEALTH_NOT_OK_CODE = JsonResponse::HTTP_BAD_REQUEST;

    /**
     * @Assert\Type("string")
     */
    protected $healthOkStatusMessage;

    /**
     * @Assert\Type("string")
     */
    protected $healthNotOkStatusMessage;

    /**
     * @var DiagnosticContainer
     */
    protected $diagnosticContainer;

    public function __construct(
        $healthOkStatusMessage = 'Application is healthy',
        $healthNotOkStatusMessage = 'Application is unhealthy'
    ) {
        $this->healthOkStatusMessage = $healthOkStatusMessage;
        $this->healthNotOkStatusMessage = $healthNotOkStatusMessage;
        Validator::validate($this);

        $diagnosticCollection = new DiagnosticCollection();
        $this->diagnosticContainer = new DiagnosticContainer(
            $diagnosticCollection
        );
        $this->healthStatusMessage = $healthNotOkStatusMessage;
    }

    public function addDiagnostic(DiagnosticInterface $diagnostic)
    {
        $this->diagnosticContainer->addDiagnostic($diagnostic);
    }

    abstract public function displayHealthCheckReport();

    abstract public function displayStatusCheckReport();
}
