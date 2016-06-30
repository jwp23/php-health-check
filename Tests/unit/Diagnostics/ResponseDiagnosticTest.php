<?php
namespace Diagnostics;

use GuzzleHttp\Psr7\Response;
use Codeception\Util\Stub;

class ResponseDiagnosticTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testAccessResponse()
    {
        $webPageDiagnostic = Stub::make(
            'BB\WPHealthCheck\Diagnostics\ResponseDiagnostic'
        );

        $response = new Response();
        $webPageDiagnostic->setGuzzleResponse($response);
        $this->assertSame($response, $webPageDiagnostic->getGuzzleResponse());
    }
}
