<?php

namespace BB\WPHealthCheck\Diagnostics;

use BB\WPHealthCheck\Validation\Validator;

class StringInResponseDiagnostic extends ResponseDiagnostic
{

    /**
     * @Assert\Type("string")
     */
    protected $stringToFind;

    public function __construct($description, $stringToFind)
    {
        parent::__construct($description);
        $this->stringToFind = $stringToFind;
        Validator::validate($this);
    }

    public function runDiagnostic()
    {
        $response = $this->getGuzzleResponse();
        $this->didDiagnosticPass =
            strpos($response->getBody(), $this->stringToFind) !== false;
        $this->diagnosticResult = $this->didDiagnosticPass;
    }
}
