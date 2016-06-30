<?php

namespace BB\WPHealthCheck\Diagnostics;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseStatusCodeDiagnostic extends ResponseDiagnostic
{
    const EXPECTED_STATUS_CODE = JsonResponse::HTTP_OK;

    public function __construct($description)
    {
        parent::__construct($description);
    }

    public function runDiagnostic()
    {
        $response = $this->getGuzzleResponse();
        $this->didDiagnosticPass = $response->getStatusCode() ===
            self::EXPECTED_STATUS_CODE;
        $this->diagnosticResult = $this->didDiagnosticPass;
    }
}
