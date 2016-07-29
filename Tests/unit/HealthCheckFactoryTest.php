<?php

namespace BB\WPHealthCheck\Tests\unit;

use Codeception\Util\Stub;
use BB\WPHealthCheck\Tests\unit\Mocks\SimpleDiagnosticTest;

class HealthCheckFactoryTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorExceptionHealthOkStatusMessageIsInteger()
    {
        $healthFactory = Stub::constructEmpty(
            'BB\WPHealthCheck\HealthCheckFactory',
            [
                'healthOkStatusMessage' => 123,
                'healthNotOkStatusMessage' => 'foo',
            ]
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorExceptionHealthNotOkStatusMessageIsInteger()
    {
        $healthFactory = Stub::constructEmpty(
            'BB\WPHealthCheck\HealthCheckFactory',
            [
                'healthOkStatusMessage' => 'foo',
                'healthNotOkStatusMessage' => 123,
            ]
        );
    }

    public function testConstructorIfHealthStatusMessageArgumentsAreStrings()
    {
        $exception = null;
        try {
            $healthFactory = Stub::constructEmpty(
                'BB\WPHealthCheck\HealthCheckFactory',
                [
                    'healthOkStatusMessage' => 'foo',
                    'healthNotOkStatusMessage' => 'bar',
                ]
            );
        } catch (\InvalidArgumentException $exception) {
        }

        $this->assertNull($exception);
    }

    public function testAddDiagnosticAddsDiagnosticToDiagnosticContainer()
    {
        $daignostic = new SimpleDiagnosticTest();
        $diagnosticContainer = Stub::makeEmpty(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['addDiagnostic' => Stub::once()],
            $this
        );

        $healthFactory = Stub::make(
            'BB\WPHealthCheck\HealthCheckFactory',
            ['diagnosticContainer' => $diagnosticContainer]
        );
        $healthFactory->addDiagnostic($daignostic);
    }
}
