<?php

namespace BB\WPHealthCheck\Tests\unit;

use BB\WPHealthCheck\DiagnosticContainer;
use Codeception\Util\Stub;
use BB\WPHealthCheck\Tests\unit\Mocks\SimpleDiagnosticTest;
use BB\WPHealthCheck\DiagnosticCollection;

class DiagnosticContainerTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testAddDiagnosticWithValidDiagnosticObjectReturnsSelf()
    {
        $diagnosticCollection = new DiagnosticCollection();
        $diagnosticContainer = new DiagnosticContainer($diagnosticCollection);
        $result = $diagnosticContainer->addDiagnostic(
            new SimpleDiagnosticTest()
        );
        $this->assertInstanceOf(
            'BB\WPHealthCheck\DiagnosticContainer',
            $result
        );
    }

    public function testAddDiagnosticAddsDiagnosticToCollection()
    {
        $diagnostic = Stub::make(
            'BB\WPHealthCheck\Tests\unit\Mocks\SimpleDiagnosticTest',
            ['runDiagnostic' => Stub::once()]
        );
        $diagnosticCollection = new DiagnosticCollection();
        $diagnosticContainer = new DiagnosticContainer($diagnosticCollection);
        $diagnosticContainer->addDiagnostic($diagnostic);
        $diagnosticContainer->runFullDiagnostics();
    }

    /**
     * @expectedException \Exception
     */
    public function testIsApplicationHealthyThrowsExceptionAsDefault()
    {
        $diagnosticCollection = new DiagnosticCollection();
        $diagnosticContainer = new DiagnosticContainer($diagnosticCollection);
        $this->assertFalse($diagnosticContainer->isApplicationHealthy());
    }

    public function testIsApplicationHealthyWorksWithOneDiagnosticFalse()
    {
        $diagnosticFoo = new SimpleDiagnosticTest(false);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );
        $this->assertFalse($diagnosticContainer->isApplicationHealthy());
    }

    public function testIsApplicationHealthyWorksWithOneDiagnosticTrue()
    {
        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );
        $this->assertTrue($diagnosticContainer->isApplicationHealthy());
    }

    public function testIsApplicationHealthyMultipleDiagnosticsIfOneFalse()
    {
        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticBar = new SimpleDiagnosticTest(false);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo, $diagnosticBar]]
        );
        $this->assertFalse($diagnosticContainer->isApplicationHealthy());
    }

    public function testIsApplicationHealthyMultipleDiagnosticsAllTrue()
    {
        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticBar = new SimpleDiagnosticTest(true);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo, $diagnosticBar]]
        );
        $this->assertTrue($diagnosticContainer->isApplicationHealthy());
    }

    public function testRunFullDiagnosticsReturnsInstanceofSelf()
    {
        $diagnosticFoo = new SimpleDiagnosticTest();
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );
        $result = $diagnosticContainer->runFullDiagnostics();
        $this->assertInstanceOf(
            'BB\WPHealthCheck\DiagnosticContainer',
            $result
        );
    }

    public function testRunDiagnosticsUntilFailReturnsInstanceofSelf()
    {
        $diagnosticFoo = new SimpleDiagnosticTest();
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );
        $result = $diagnosticContainer->runDiagnosticsUntilFail();
        $this->assertInstanceOf(
            'BB\WPHealthCheck\DiagnosticContainer',
            $result
        );
    }

    /**
     * @expectedException \Exception
     */
    public function testRunFullDiagnosticsExceptionIfEmptyDiagnosticCollection()
    {
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => []]
        );
        $diagnosticContainer->runFullDiagnostics();
    }

    /**
     * @expectedException \Exception
     */
    public function testRunDiagnosticsUntilFailIfEmptyDiagnosticCollection()
    {
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => []]
        );
        $diagnosticContainer->runDiagnosticsUntilFail();
    }

    public function testRunFullDiagnosticRunsAllDiagnostics()
    {
        $diagnosticFoo = Stub::makeEmpty(
            'BB\WPHealthCheck\Tests\unit\Mocks\SimpleDiagnosticTest',
            [
                'runDiagnostic' => Stub::once(),
                'hasDiagnosticPassed' => false,
            ],
            $this
        );

        $diagnosticBar = Stub::makeEmpty(
            'BB\WPHealthCheck\Tests\unit\Mocks\SimpleDiagnosticTest',
            [
                'runDiagnostic' => Stub::once(),
                'hasDiagnosticPassed' => false,
            ],
            $this
        );
        $diagnosticContainer = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\DiagnosticContainer',
            'runFullDiagnostics',
            [
                'diagnosticCollection' => [$diagnosticFoo, $diagnosticBar],
            ]
        );
        $diagnosticContainer->runFullDiagnostics();
    }

    public function testRunDiagnosticsRunsUntilFailOptionStopsAfterFirstFail()
    {
        $diagnosticFoo = Stub::makeEmpty(
            'BB\WPHealthCheck\Tests\unit\Mocks\SimpleDiagnosticTest',
            [
                'runDiagnostic' => Stub::once(),
                'hasDiagnosticPassed' => false,
            ],
            $this
        );

        $diagnosticBar = Stub::makeEmpty(
            'BB\WPHealthCheck\Tests\unit\Mocks\SimpleDiagnosticTest',
            [
                'runDiagnostic' => Stub::never(),
                'hasDiagnosticPassed' => false,
            ],
            $this
        );
        $diagnosticContainer = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\DiagnosticContainer',
            'runDiagnosticsUntilFail',
            ['diagnosticCollection' => [$diagnosticFoo, $diagnosticBar]]
        );
        $diagnosticContainer->runDiagnosticsUntilFail();
    }

    public function testRunFullDiagnosticsWithOneDiagnosticThatFails()
    {

        $diagnosticFoo = new SimpleDiagnosticTest(false);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );
        $isApplicationHealthy = $diagnosticContainer
            ->runFullDiagnostics()
            ->isApplicationHealthy();
        $this->assertFalse($isApplicationHealthy);
    }

    public function testRunFullDiagnosticsWithOneDiagnosticThatPass()
    {

        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );
        $isApplicationHealthy = $diagnosticContainer
            ->runFullDiagnostics()
            ->isApplicationHealthy();
        $this->assertTrue($isApplicationHealthy);
    }

    public function testRunFullDiagnosticsWithOneFailure()
    {

        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticBar = new SimpleDiagnosticTest(false);
        $diagnosticBaz = new SimpleDiagnosticTest(true);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            [
                'diagnosticCollection' =>
                    [$diagnosticFoo, $diagnosticBar, $diagnosticBaz]
            ]
        );
        $isApplicationHealthy = $diagnosticContainer
            ->runFullDiagnostics()
            ->isApplicationHealthy();
        $this->assertFalse($isApplicationHealthy);
    }

    public function testRunFullDiagnosticsWithAllDiagnosticsPass()
    {
        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticBar = new SimpleDiagnosticTest(true);
        $diagnosticBaz = new SimpleDiagnosticTest(true);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            [
                'diagnosticCollection' =>
                    [$diagnosticFoo, $diagnosticBar, $diagnosticBaz],
            ]
        );
        $isApplicationHealthy = $diagnosticContainer
            ->runFullDiagnostics()
            ->isApplicationHealthy();
        $this->assertTrue($isApplicationHealthy);
    }

    public function testRunDiagnosticsUntilFailWithOneDiagnosticFails()
    {

        $diagnosticFoo = new SimpleDiagnosticTest(false);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );
        $isApplicationHealthy = $diagnosticContainer
            ->runDiagnosticsUntilFail()
            ->isApplicationHealthy();
        $this->assertFalse($isApplicationHealthy);
    }

    public function testRunDiagnosticsUntilFailWithOneDiagnosticPass()
    {

        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );
        $isApplicationHealthy = $diagnosticContainer
            ->runDiagnosticsUntilFail()
            ->isApplicationHealthy();
        $this->assertTrue($isApplicationHealthy);
    }

    public function testRunDiagnosticsUntilFailWithOneFailure()
    {

        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticBar = new SimpleDiagnosticTest(false);
        $diagnosticBaz = new SimpleDiagnosticTest(true);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            [
                'diagnosticCollection' =>
                    [$diagnosticFoo, $diagnosticBar, $diagnosticBaz],
            ]
        );
        $isApplicationHealthy = $diagnosticContainer
            ->runDiagnosticsUntilFail()
            ->isApplicationHealthy();
        $this->assertFalse($isApplicationHealthy);
    }

    public function testRunDiagnosticsUntilFailAllDiagnosticsPass()
    {

        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticBar = new SimpleDiagnosticTest(true);
        $diagnosticBaz = new SimpleDiagnosticTest(true);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            [
                'diagnosticCollection' =>
                    [$diagnosticFoo, $diagnosticBar, $diagnosticBaz],
            ]
        );
        $isApplicationHealthy = $diagnosticContainer
            ->runDiagnosticsUntilFail()
            ->isApplicationHealthy();
        $this->assertTrue($isApplicationHealthy);
    }
}
