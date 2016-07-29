<?php
namespace Diagnostics;

use GuzzleHttp\Psr7\Response;
use BB\WPHealthCheck\Diagnostics\ResponseStatusCodeDiagnostic;

class ResponseStatusCodeDiagnosticTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testHasDiagnosticPassedIsTrueIf200ExpectedStatusCodeFound()
    {
        $response = new Response(200);
        $webPageStatusCodeDiagnostic = new ResponseStatusCodeDiagnostic(
            'Url returns status code 200'
        );
        $webPageStatusCodeDiagnostic->setGuzzleResponse($response);
        $webPageStatusCodeDiagnostic->runDiagnostic();
        $this->assertTrue($webPageStatusCodeDiagnostic->hasDiagnosticPassed());
    }

    public function testHasDiagnosticPassedIsFalseIf200StatusCodeNotFound()
    {
        $response = new Response(123);
        $webPageStatusCodeDiagnostic = new ResponseStatusCodeDiagnostic(
            'url returns status code 200'
        );
        $webPageStatusCodeDiagnostic->setGuzzleResponse($response);
        $webPageStatusCodeDiagnostic->runDiagnostic();
        $this->assertFalse($webPageStatusCodeDiagnostic->hasDiagnosticPassed());
    }

    public function testGetDiagnosticResultIsTrueIf200StatusCodeFound()
    {
        $response = new Response(200);
        $webPageStatusCodeDiagnostic = new ResponseStatusCodeDiagnostic(
            'url returns status code 200'
        );
        $webPageStatusCodeDiagnostic->setGuzzleResponse($response);
        $webPageStatusCodeDiagnostic->runDiagnostic();
        $this->assertTrue($webPageStatusCodeDiagnostic->getDiagnosticResult());
    }

    public function testGetDiagnosticResultIsFalseIf200StatusCodeNotFound()
    {
        $response = new Response(123);
        $webPageStatusCodeDiagnostic = new ResponseStatusCodeDiagnostic(
            'url returns status code 200'
        );
        $webPageStatusCodeDiagnostic->setGuzzleResponse($response);
        $webPageStatusCodeDiagnostic->runDiagnostic();
        $this->assertFalse($webPageStatusCodeDiagnostic->getDiagnosticResult());
    }
}
