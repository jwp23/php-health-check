<?php
namespace Diagnostics;

use GuzzleHttp\Psr7\Response;
use BB\WPHealthCheck\Diagnostics\StringNotInResponseDiagnostic;

class StringNotInResponseDiagnosticTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testHasDiagnosticPassedReturnsTrueIfStringNotInPage()
    {
        $response = new Response(200, [], 'foo');
        $stringNotInResponseDiagnostic = new StringNotInResponseDiagnostic(
            '"foo" found in page',
            'bar'
        );
        $stringNotInResponseDiagnostic->setGuzzleResponse($response);
        $stringNotInResponseDiagnostic->runDiagnostic();
        $this->assertTrue($stringNotInResponseDiagnostic->hasDiagnosticPassed());
    }

    public function testHasDiagnosticPassedReturnsFalseIfStringInPage()
    {
        $response = new Response(200, [], 'foo');
        $stringNotInResponseDiagnostic = new StringNotInResponseDiagnostic(
            '"foo" found in page',
            'foo'
        );
        $stringNotInResponseDiagnostic->setGuzzleResponse($response);
        $stringNotInResponseDiagnostic->runDiagnostic();
        $this->assertFalse($stringNotInResponseDiagnostic->hasDiagnosticPassed());
    }

    public function testGetDiagnosticResultReturnsTrueIfStringNotInPage()
    {
        $response = new Response(200, [], 'foo');
        $stringNotInResponseDiagnostic = new StringNotInResponseDiagnostic(
            '"foo" found in page',
            'bar'
        );
        $stringNotInResponseDiagnostic->setGuzzleResponse($response);
        $stringNotInResponseDiagnostic->runDiagnostic();
        $this->assertTrue($stringNotInResponseDiagnostic->getDiagnosticResult());
    }

    public function testGetDiagnosticResultReturnsFalseIfStringInPage()
    {
        $response = new Response(200, [], 'foo');
        $stringNotInResponseDiagnostic = new StringNotInResponseDiagnostic(
            '"foo" found in page',
            'foo'
        );
        $stringNotInResponseDiagnostic->setGuzzleResponse($response);
        $stringNotInResponseDiagnostic->runDiagnostic();
        $this->assertFalse($stringNotInResponseDiagnostic->getDiagnosticResult());
    }
}
