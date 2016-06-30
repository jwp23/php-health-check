<?php

namespace BB\WPHealthCheck\Diagnostics;

class BuildInfo extends SimpleDiagnostic
{
    const DESCRIPTION = 'buildInfo';

    protected $additionalInfo;
    
    public function __construct($buildInfo = [])
    {
        parent::__construct(self::DESCRIPTION);
        $this->additionalInfo = new AdditionalInfo(
            self::DESCRIPTION,
            $buildInfo
        );
    }
    
    public function runDiagnostic()
    {
        $this->additionalInfo->runDiagnostic();
        $this->didDiagnosticPass = $this->additionalInfo->hasDiagnosticPassed();
        $this->diagnosticResult = $this->additionalInfo->getDiagnosticResult();
    }
}
