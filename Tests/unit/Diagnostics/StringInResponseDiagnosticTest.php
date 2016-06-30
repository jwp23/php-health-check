<?php
namespace Diagnostics;

use BB\WPHealthCheck\Diagnostics\StringInResponseDiagnostic;
use GuzzleHttp\Psr7\Response;

class StringInResponseDiagnosticTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testHasDiagnosticPassedReturnsFalseIfStringNotInPage()
    {
        $response = new Response(200, [], 'foo');
        $stringInWebPageDiagnostic = new StringInResponseDiagnostic(
            '"foo" found in page',
            'bar'
        );
        $stringInWebPageDiagnostic->setGuzzleResponse($response);
        $stringInWebPageDiagnostic->runDiagnostic();
        $this->assertFalse($stringInWebPageDiagnostic->hasDiagnosticPassed());
    }

    public function testHasDiagnosticPassedReturnsTrueIfStringInPage()
    {
        $response = new Response(200, [], 'foo');
        $stringInWebPageDiagnostic = new StringInResponseDiagnostic(
            '"foo" found in page',
            'foo'
        );
        $stringInWebPageDiagnostic->setGuzzleResponse($response);
        $stringInWebPageDiagnostic->runDiagnostic();
        $this->assertTrue($stringInWebPageDiagnostic->hasDiagnosticPassed());
    }

    public function testGetDiagnosticResultReturnsFalseIfStringNotInPage()
    {
        $response = new Response(200, [], 'foo');
        $stringInWebPageDiagnostic = new StringInResponseDiagnostic(
            '"foo" found in page',
            'foo'
        );
        $stringInWebPageDiagnostic->setGuzzleResponse($response);
        $stringInWebPageDiagnostic->runDiagnostic();
        $this->assertTrue($stringInWebPageDiagnostic->getDiagnosticResult());
    }

    public function testGetDiagnosticResultReturnsTrueIfStringInPage()
    {
        $response = new Response(200, [], 'foo');
        $stringInWebPageDiagnostic = new StringInResponseDiagnostic(
            '"foo" found in page',
            'foo'
        );
        $stringInWebPageDiagnostic->setGuzzleResponse($response);
        $stringInWebPageDiagnostic->runDiagnostic();
        $this->assertTrue($stringInWebPageDiagnostic->getDiagnosticResult());
    }
}
