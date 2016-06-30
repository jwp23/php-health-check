<?php

namespace BB\WPHealthCheck\Tests\unit;

use Codeception\Util\Stub;
use BB\WPHealthCheck\Tests\unit\Mocks\SimpleDiagnosticTest;

class ApplicationCheckTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testAddDiagnosticAddsDiagnostic()
    {
        $diagnosticContainer = Stub::makeEmpty(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['addDiagnostic' => Stub::once()],
            $this
        );
        $healthCheckFactory = Stub::make(
            'BB\WPHealthCheck\HealthCheckFactory',
            ['diagnosticContainer' => $diagnosticContainer]
        );
        $ApplicationCheck = Stub::make(
            'BB\WPHealthCheck\ApplicationCheck',
            ['healthCheckFactory' => $healthCheckFactory]
        );
        $diagnosticFoo = new SimpleDiagnosticTest();
        $ApplicationCheck->addDiagnostic($diagnosticFoo);
    }

    public function testDisplayHealthCheckReportDisplaysReport()
    {
        $healthCheckFactory = Stub::make(
            'BB\WPHealthCheck\HealthCheckFactory',
            ['displayHealthCheckReport' => Stub::once()],
            $this
        );
        $ApplicationCheck = Stub::make(
            'BB\WPHealthCheck\ApplicationCheck',
            ['healthCheckFactory' => $healthCheckFactory]
        );
        $ApplicationCheck->displayHealthCheckReport();
    }

    public function testDisplayStatusCheckReportDisplaysReport()
    {
        $healthCheckFactory = Stub::make(
            'BB\WPHealthCheck\HealthCheckFactory',
            ['displayStatusCheckReport' => Stub::once()],
            $this
        );
        $ApplicationCheck = Stub::make(
            'BB\WPHealthCheck\ApplicationCheck',
            ['healthCheckFactory' => $healthCheckFactory]
        );
        $ApplicationCheck->displayStatusCheckReport();
    }
}
