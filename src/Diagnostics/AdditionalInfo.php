<?php


namespace BB\WPHealthCheck\Diagnostics;

class AdditionalInfo extends SimpleDiagnostic
{
    protected $additionalInfo;

    public function __construct($description, $additionalInfo)
    {
        parent::__construct($description);
        $this->additionalInfo = $additionalInfo;
    }

    public function runDiagnostic()
    {
        $this->diagnosticResult = $this->additionalInfo;
        $this->didDiagnosticPass = true;
    }
}
