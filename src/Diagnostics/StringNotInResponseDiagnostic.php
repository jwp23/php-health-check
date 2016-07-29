<?php

namespace BB\WPHealthCheck\Diagnostics;

use BB\WPHealthCheck\Validation\Validator;

class StringNotInResponseDiagnostic extends ResponseDiagnostic
{
    /**
     * @Assert\Type("string")
     */
    protected $stringNotToFind;

    public function __construct($description, $stringNotToFind)
    {
        parent::__construct($description);
        $this->stringNotToFind = $stringNotToFind;
        Validator::validate($this);
    }

    public function runDiagnostic()
    {
        $response = $this->getGuzzleResponse();
        $this->didDiagnosticPass =
            strpos($response->getBody(), $this->stringNotToFind) === false;
        $this->diagnosticResult = $this->didDiagnosticPass;
    }
}
