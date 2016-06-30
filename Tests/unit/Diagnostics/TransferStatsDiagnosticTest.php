<?php
namespace Diagnostics;

use Codeception\Util\Stub;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\TransferStats;

class TransferStatsDiagnosticTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testAccessTransferStats()
    {
        $request = new Request(null, '');
        $transferStats = new TransferStats($request, null);
        $transferStatsDiagnostic = Stub::make(
            'BB\WPHealthCheck\Diagnostics\TransferStatsDiagnostic'
        );
        $transferStatsDiagnostic->setGuzzleTransferStats($transferStats);
        $this->assertSame(
            $transferStats,
            $transferStatsDiagnostic->getGuzzleTransferStates()
        );
    }
}
