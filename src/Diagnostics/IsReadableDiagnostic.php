<?php

namespace BB\WPHealthCheck\Diagnostics;

use SplFileObject;

class IsReadableDiagnostic extends SimpleDiagnostic
{

    protected $splFileObject;
    protected $isHealthy;

    public function __construct($description, SplFileObject $splFileObject)
    {

        parent::__construct($description);
        $this->splFileObject = $splFileObject;
    }

    public function runDiagnostic()
    {
        $this->didDiagnosticPass = $this->splFileObject->isReadable();
        $this->diagnosticResult = $this->didDiagnosticPass;
    }
}
