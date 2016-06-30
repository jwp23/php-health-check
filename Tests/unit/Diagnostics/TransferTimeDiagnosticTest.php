<?php
namespace Diagnostics;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\TransferStats;
use BB\WPHealthCheck\Diagnostics\TransferTimeDiagnostic;

class TransferTimeDiagnosticTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testHasDiagnosticPassedIfTransferTimeLessThanExpected()
    {
        $request = new Request(null, '');
        $transferStats = new TransferStats($request, null, 0);
        $transferStatsDiagnostics = new TransferTimeDiagnostic(
            'Transfer time less than or equal to expected time',
            3
        );
        $transferStatsDiagnostics->setGuzzleTransferStats($transferStats);
        $transferStatsDiagnostics->runDiagnostic();
        $this->assertTrue($transferStatsDiagnostics->hasDiagnosticPassed());
    }

    public function testHasDiagnosticPassedIfTransferTimeEqualsExpected()
    {
        $request = new Request(null, '');
        $transferStats = new TransferStats($request, null, 3);
        $transferStatsDiagnostics = new TransferTimeDiagnostic(
            'Transfer time less than or equal to expected time',
            3
        );
        $transferStatsDiagnostics->setGuzzleTransferStats($transferStats);
        $transferStatsDiagnostics->runDiagnostic();
        $this->assertTrue($transferStatsDiagnostics->hasDiagnosticPassed());
    }

    public function testHasDiagnosticPassedIfTransferTimeGreaterThanExpected()
    {
        $request = new Request(null, '');
        $transferStats = new TransferStats($request, null, 5);
        $transferStatsDiagnostics = new TransferTimeDiagnostic(
            'Transfer time less than or equal to expected time',
            3
        );
        $transferStatsDiagnostics->setGuzzleTransferStats($transferStats);
        $transferStatsDiagnostics->runDiagnostic();
        $this->assertFalse($transferStatsDiagnostics->hasDiagnosticPassed());
    }

    public function testGetDiagnosticResultIfTransferTimeLessThanExpected()
    {
        $request = new Request(null, '');
        $transferStats = new TransferStats($request, null, 0);
        $transferStatsDiagnostics = new TransferTimeDiagnostic(
            'Transfer time less than or equal to expected time',
            3
        );
        $transferStatsDiagnostics->setGuzzleTransferStats($transferStats);
        $transferStatsDiagnostics->runDiagnostic();
        $this->assertTrue($transferStatsDiagnostics->getDiagnosticResult());
    }

    public function testGetDiagnosticResultIfTransferTimeEqualsExpected()
    {
        $request = new Request(null, '');
        $transferStats = new TransferStats($request, null, 3);
        $transferStatsDiagnostics = new TransferTimeDiagnostic(
            'Transfer time less than or equal to expected time',
            3
        );
        $transferStatsDiagnostics->setGuzzleTransferStats($transferStats);
        $transferStatsDiagnostics->runDiagnostic();
        $this->assertTrue($transferStatsDiagnostics->getDiagnosticResult());
    }

    public function testGetDiagnosticResultIfTransferTimeGreaterThanExpected()
    {
        $request = new Request(null, '');
        $transferStats = new TransferStats($request, null, 5);
        $transferStatsDiagnostics = new TransferTimeDiagnostic(
            'Transfer time less than or equal to expected time',
            3
        );
        $transferStatsDiagnostics->setGuzzleTransferStats($transferStats);
        $transferStatsDiagnostics->runDiagnostic();
        $this->assertFalse($transferStatsDiagnostics->getDiagnosticResult());
    }
}
