<?php


namespace BB\WPHealthCheck\Tests\unit\Mocks;

use BB\WPHealthCheck\Diagnostics\SimpleDiagnostic;

class SimpleDiagnosticTest extends SimpleDiagnostic
{

    /**
     * @var bool
     */
    protected $diagnosticResult;

    protected $description = 'Diagnostic Test Object';

    public function __construct($didPass = false)
    {
        parent::__construct('Diagnostic Implementation for Testing');
        $this->didDiagnosticPass = $didPass;
    }

    public function runDiagnostic()
    {
        $this->diagnosticResult = $this->didDiagnosticPass;
    }
}
