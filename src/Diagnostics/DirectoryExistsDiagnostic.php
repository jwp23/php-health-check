<?php

namespace BB\WPHealthCheck\Diagnostics;

use SplFileObject;

class DirectoryExistsDiagnostic extends SimpleDiagnostic
{

    protected $splFileObject;
    protected $splFileObjectMethod;
    protected $isHealthy;

    public function __construct($description, SplFileObject $splFileObject)
    {
        parent::__construct($description);
        $this->splFileObject = $splFileObject;
    }

    public function runDiagnostic()
    {
        $this->didDiagnosticPass = $this->splFileObject->isDir();
        $this->diagnosticResult = $this->didDiagnosticPass;
    }
}
