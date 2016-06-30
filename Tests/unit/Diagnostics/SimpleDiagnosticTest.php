<?php
namespace BB\WPHealthCheck\Tests\unit\Diagnostics;

use Codeception\Util\Stub;

class SimpleDiagnosticTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testGetDescriptionReturnsDescription()
    {
        $description = 'Foo Test';
        $diagnostic = Stub::make(
            'BB\WPHealthCheck\Diagnostics\SimpleDiagnostic',
            ['description' => $description]
        );

        $this->assertSame(
            $description,
            $diagnostic->getDiagnosticDescription()
        );
    }

    public function testHasDiagnosticPassedReturnsDidDiagnosticPassProperty()
    {
        $didDiagnosticPass = false;
        $diagnostic = Stub::make(
            'BB\WPHealthCheck\Diagnostics\SimpleDiagnostic',
            ['didDiagnosticPass' => $didDiagnosticPass]
        );
        $this->assertSame(
            $didDiagnosticPass,
            $diagnostic->hasDiagnosticPassed()
        );
    }

    public function testGetDiagnosticResultReturnsDiagnosticResultProperty()
    {
        $diagnosticResult = 'foo';
        $diagnostic = Stub::make(
            'BB\WPHealthCheck\Diagnostics\SimpleDiagnostic',
            ['diagnosticResult' => $diagnosticResult]
        );
        $this->assertSame(
            $diagnosticResult,
            $diagnostic->getDiagnosticResult()
        );
    }
}
