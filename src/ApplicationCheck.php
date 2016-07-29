<?php


namespace BB\WPHealthCheck;

use BB\WPHealthCheck\Diagnostics\DiagnosticInterface;

abstract class ApplicationCheck
{
    protected $healthCheckFactory;

    public function __construct(HealthCheckFactory $healthCheckFactory)
    {
        $this->healthCheckFactory = $healthCheckFactory;
    }

    public function addDiagnostic(DiagnosticInterface $diagnostic)
    {
        $this->healthCheckFactory->addDiagnostic($diagnostic);
        return $this;
    }

    public function displayHealthCheckReport()
    {
        $this->addApplicationDiagnostics();
        $this->healthCheckFactory->displayHealthCheckReport();
    }

    public function displayStatusCheckReport()
    {
        $this->addApplicationDiagnostics();
        $this->healthCheckFactory->displayStatusCheckReport();
    }

    abstract protected function addApplicationDiagnostics();
}
